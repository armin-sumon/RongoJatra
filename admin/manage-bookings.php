<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
if(isset($_POST['update']))
{
$bookingid=$_POST['bookingid'];
$status=$_POST['status'];
$remark=$_POST['remark'];
$cancellation_reason=$_POST['cancellation_reason'];

$sql="update tblbooking set status=:status,AdminRemark=:remark,CancellationReason=:cancellation_reason where BookingId=:bookingid";
$query = $dbh->prepare($sql);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->bindParam(':remark',$remark,PDO::PARAM_STR);
$query->bindParam(':cancellation_reason',$cancellation_reason,PDO::PARAM_STR);
$query->bindParam(':bookingid',$bookingid,PDO::PARAM_STR);
$query->execute();

// If booking is confirmed, add welcome message to chat
if($status == 1) {
    $welcome_message = "Your booking has been confirmed! Welcome to RongoJatra. Our team will assist you with your travel arrangements.";
    $chat_sql = "INSERT INTO tblchatmessages (BookingId, SenderType, Message) VALUES (:booking_id, 'admin', :message)";
    $chat_query = $dbh->prepare($chat_sql);
    $chat_query->bindParam(':booking_id', $bookingid, PDO::PARAM_STR);
    $chat_query->bindParam(':message', $welcome_message, PDO::PARAM_STR);
    $chat_query->execute();
}

// Sync payment state with booking status for Test Payment flow
try {
    if($status == 1) {
        // Confirmed → mark latest pending payment as success and booking as paid
        $p = $dbh->prepare("SELECT id, amount FROM tblpayments WHERE booking_id = :bid AND status = 'pending' ORDER BY id DESC LIMIT 1");
        $p->execute([':bid' => $bookingid]);
        $pay = $p->fetch(PDO::FETCH_ASSOC);
        if($pay) {
            $dbh->prepare("UPDATE tblpayments SET status='success' WHERE id=:id")->execute([':id' => $pay['id']]);
            $dbh->prepare("UPDATE tblbooking SET payment_status='paid', paid_amount=:amt WHERE BookingId=:bid")
                ->execute([':amt' => $pay['amount'], ':bid' => $bookingid]);
        } else {
            // No pending payment row found; at least mark booking as paid
            $dbh->prepare("UPDATE tblbooking SET payment_status='paid' WHERE BookingId=:bid")
                ->execute([':bid' => $bookingid]);
        }
    } else if($status == 0) {
        // Cancelled → mark payments cancelled and booking payment_status cancelled
        $dbh->prepare("UPDATE tblpayments SET status='cancelled' WHERE booking_id=:bid AND status IN ('pending','failed')")
            ->execute([':bid' => $bookingid]);
        $dbh->prepare("UPDATE tblbooking SET payment_status='cancelled', paid_amount=NULL WHERE BookingId=:bid")
            ->execute([':bid' => $bookingid]);
    } else if($status == 2) {
        // Pending → reflect payment as pending
        $dbh->prepare("UPDATE tblbooking SET payment_status='pending', paid_amount=NULL WHERE BookingId=:bid")
            ->execute([':bid' => $bookingid]);
    }
} catch(PDOException $e) {
    // swallow but log if needed
}

$msg="Booking updated successfully";
}

// Handle sending admin chat message
if(isset($_POST['send_admin_message'])) {
    $booking_id = $_POST['booking_id'];
    $message = $_POST['admin_message'];
    
    try {
        $sql = "INSERT INTO tblchatmessages (BookingId, SenderType, Message) VALUES (:booking_id, 'admin', :message)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':booking_id', $booking_id, PDO::PARAM_STR);
        $query->bindParam(':message', $message, PDO::PARAM_STR);
        $query->execute();
        
        $msg = "Message sent successfully.";
    } catch(PDOException $e) {
        $error = "Error sending message: " . $e->getMessage();
    }
}

?>
<!DOCTYPE HTML>
<html>
<head>
<title>TMS | Admin Manage Bookings</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="Pooled Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
<style>
.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
</style>
</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
              <!--header start here-->
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Bookings </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Manage Bookings</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
						
							<div class="row">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>#</th>
													<th>Booking ID</th>
													<th>Customer Email</th>
													<th>Package</th>
													<th>From Date</th>
													<th>To Date</th>
													<th>Booking Date</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
<?php 
$sql = "SELECT b.*, p.PackageName, p.PackageType, p.PackageLocation, p.PackagePrice 
        FROM tblbooking b 
        LEFT JOIN tbltourpackages p ON b.PackageId = p.PackageId 
        ORDER BY b.RegDate DESC";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
												<tr>
													<td><?php echo htmlentities($cnt);?></td>
													<td><?php echo htmlentities($result->BookingId);?></td>
													<td><?php echo htmlentities($result->UserEmail);?></td>
													<td>
														<strong><?php echo htmlentities($result->PackageName);?></strong><br>
														<small><?php echo htmlentities($result->PackageType);?></small><br>
														<small><?php echo htmlentities($result->PackageLocation);?></small>
													</td>
													<td><?php echo htmlentities($result->FromDate);?></td>
													<td><?php echo htmlentities($result->ToDate);?></td>
													<td><?php echo date('d M Y, H:i', strtotime($result->RegDate));?></td>
													<td>
														<?php if($result->status == 1) { ?>
															<span class="label label-success">Confirmed</span>
														<?php } else if($result->status == 0) { ?>
															<span class="label label-danger">Cancelled</span>
														<?php } else { ?>
															<span class="label label-warning">Pending</span>
														<?php } ?>
													</td>
													<td>
														<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#bookingModal<?php echo $result->BookingId; ?>">
															View Details
														</button>
														<?php if($result->status == 1): // Confirmed ?>
														<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#chatModal<?php echo $result->BookingId; ?>">
															Chat
														</button>
														<?php endif; ?>
													</td>
												</tr>
												
												<!-- Booking Details Modal -->
												<div class="modal fade" id="bookingModal<?php echo $result->BookingId; ?>" tabindex="-1" role="dialog">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Booking Details - ID: <?php echo $result->BookingId; ?></h4>
															</div>
															<div class="modal-body">
																<form method="post">
																	<input type="hidden" name="bookingid" value="<?php echo $result->BookingId; ?>">
																	
																	<div class="row">
																		<div class="col-md-6">
																			<h5><strong>Customer Information</strong></h5>
																			<p><strong>Email:</strong> <?php echo htmlentities($result->UserEmail); ?></p>
																			<p><strong>Booking Date:</strong> <?php echo date('d M Y, H:i', strtotime($result->RegDate)); ?></p>
																		</div>
																		<div class="col-md-6">
																			<h5><strong>Package Information</strong></h5>
																			<p><strong>Package:</strong> <?php echo htmlentities($result->PackageName); ?></p>
																			<p><strong>Type:</strong> <?php echo htmlentities($result->PackageType); ?></p>
																			<p><strong>Location:</strong> <?php echo htmlentities($result->PackageLocation); ?></p>
																			<p><strong>Price:</strong> BDT <?php echo htmlentities($result->PackagePrice); ?></p>
																		</div>
																	</div>
																	
																	<div class="row">
																		<div class="col-md-6">
																			<h5><strong>Travel Dates</strong></h5>
																			<p><strong>From:</strong> <?php echo htmlentities($result->FromDate); ?></p>
																			<p><strong>To:</strong> <?php echo htmlentities($result->ToDate); ?></p>
																		</div>
																		<div class="col-md-6">
																			<h5><strong>Booking Status</strong></h5>
																			<select name="status" class="form-control">
																				<option value="1" <?php echo ($result->status == 1) ? 'selected' : ''; ?>>Confirmed</option>
																				<option value="0" <?php echo ($result->status == 0) ? 'selected' : ''; ?>>Cancelled</option>
																				<option value="2" <?php echo ($result->status == 2) ? 'selected' : ''; ?>>Pending</option>
																			</select>
																		</div>
																	</div>
																	
																	<div class="row">
																		<div class="col-md-12">
																			<h5><strong>Customer Details & Special Requests</strong></h5>
																			<div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin-bottom: 15px;">
																				<pre style="white-space: pre-wrap; font-family: inherit; margin: 0;"><?php echo htmlentities($result->Comment); ?></pre>
																			</div>
																		</div>
																	</div>
																	
																	<div class="row">
																		<div class="col-md-6">
																			<h5><strong>Admin Remark</strong></h5>
																			<textarea name="remark" class="form-control" rows="3" placeholder="Add admin remark..."><?php echo htmlentities($result->AdminRemark); ?></textarea>
																		</div>
																		<div class="col-md-6">
																			<h5><strong>Cancellation Reason</strong></h5>
																			<textarea name="cancellation_reason" class="form-control" rows="3" placeholder="Reason for cancellation (if applicable)..."><?php echo htmlentities($result->CancellationReason); ?></textarea>
																		</div>
																	</div>
																	
																	<div class="modal-footer">
																		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
																		<button type="submit" name="update" class="btn btn-primary">Update Booking</button>
																	</div>
																</form>
															</div>
														</div>
													</div>
												</div>
												
												<!-- Chat Modal for Confirmed Bookings -->
												<?php if($result->status == 1): ?>
												<div class="modal fade" id="chatModal<?php echo $result->BookingId; ?>" tabindex="-1" role="dialog">
													<div class="modal-dialog modal-lg" role="document">
														<div class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Chat - Booking #<?php echo $result->BookingId; ?> - <?php echo htmlentities($result->UserEmail); ?></h4>
															</div>
															<div class="modal-body">
																<div class="chat-container" id="chatMessages<?php echo $result->BookingId; ?>" style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; padding: 15px; background: #f8f9fa; border-radius: 5px;">
																	<?php
																	// Get chat messages
																	$chat_sql = "SELECT * FROM tblchatmessages WHERE BookingId = :booking_id ORDER BY MessageDate ASC";
																	$chat_query = $dbh->prepare($chat_sql);
																	$chat_query->bindParam(':booking_id', $result->BookingId, PDO::PARAM_STR);
																	$chat_query->execute();
																	$chat_results = $chat_query->fetchAll(PDO::FETCH_OBJ);
																	
																	foreach($chat_results as $chat_msg) {
																		$message_class = ($chat_msg->SenderType == 'admin') ? 'admin' : 'user';
																		$message_style = ($chat_msg->SenderType == 'admin') ? 'background: #007bff; color: white; margin-right: 20%;' : 'background: #6c757d; color: white; margin-left: 20%;';
																		echo '<div class="message" style="margin-bottom: 10px; padding: 8px 12px; border-radius: 5px; ' . $message_style . '">';
																		echo '<div>' . htmlentities($chat_msg->Message) . '</div>';
																		echo '<div style="font-size: 0.8em; opacity: 0.7;">' . date('d M Y, H:i', strtotime($chat_msg->MessageDate)) . '</div>';
																		echo '</div>';
																	}
																	?>
																</div>
																<form method="post" style="margin-top: 15px;">
																	<input type="hidden" name="booking_id" value="<?php echo $result->BookingId; ?>">
																	<div class="form-group">
																		<textarea name="admin_message" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
																	</div>
																	<button type="submit" name="send_admin_message" class="btn btn-primary">Send Message</button>
																</form>
															</div>
														</div>
													</div>
												</div>
												<?php endif; ?>
<?php $cnt=$cnt+1;}} ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						
						
						
						
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->	   

</body>
</html>
<?php } ?>
