<?php
session_start();
error_reporting(0);
include('includes/config.php');

// Determine current status from DB so admin updates show immediately
$bookingId = isset($_GET['booking_id']) ? (int)$_GET['booking_id'] : 0;
$currentStatus = '';
$trxIdShow = isset($_GET['trx']) ? $_GET['trx'] : '';

if($bookingId > 0) {
    try {
        // Fetch booking
        $stmt = $dbh->prepare("SELECT BookingId, status, payment_status FROM tblbooking WHERE BookingId = :id LIMIT 1");
        $stmt->execute([':id' => $bookingId]);
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch latest payment for trx/status display
        $pstmt = $dbh->prepare("SELECT trx_id, status FROM tblpayments WHERE booking_id = :id ORDER BY id DESC LIMIT 1");
        $pstmt->execute([':id' => $bookingId]);
        $pay = $pstmt->fetch(PDO::FETCH_ASSOC);
        if($pay && empty($trxIdShow) && !empty($pay['trx_id'])) {
            $trxIdShow = $pay['trx_id'];
        }

        if($booking) {
            // Prefer booking.status (admin approval) over payment status
            if((int)$booking['status'] === 1) {
                $currentStatus = 'confirmed';
            } else if((int)$booking['status'] === 0) {
                $currentStatus = 'cancelled';
            } else {
                // Pending booking: reflect payment status if available, otherwise pending
                if($pay && !empty($pay['status'])) {
                    $currentStatus = $pay['status'];
                } else if(!empty($booking['payment_status'])) {
                    $currentStatus = $booking['payment_status'];
                } else {
                    $currentStatus = 'pending';
                }
            }
        }
    } catch (Throwable $e) {
        // fallback to query string if DB lookup fails
        $currentStatus = isset($_GET['status']) ? $_GET['status'] : 'pending';
    }
} else {
    $currentStatus = isset($_GET['status']) ? $_GET['status'] : '';
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Help </title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<!--animate-->
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
</head>
<body>
<?php include('includes/header.php');?>
<div class="banner-1 ">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">RongoJatra - Tourism Management System</h1>
	</div>
</div>
<!--- /banner-1 ---->
<!--- contact ---->
<div class="contact">
	<div class="container">
	<h3> Confirmation</h3>
		<div class="col-md-10 contact-left">
			<div class="con-top animated wow fadeInUp animated" data-wow-duration="1200ms" data-wow-delay="500ms" style="visibility: visible; animation-duration: 1200ms; animation-delay: 500ms; animation-name: fadeInUp;">
		

		              <h4>  <?php echo htmlentities($_SESSION['msg']);?></h4>
					<div class="alert <?php echo ($currentStatus==='confirmed' || $currentStatus==='success') ? 'alert-success' : (in_array($currentStatus, ['cancelled','failed']) ? 'alert-danger' : 'alert-info'); ?>">
						<strong>Payment Status:</strong> <?php echo htmlentities($currentStatus); ?>
						<?php if(!empty($trxIdShow)): ?>
							<br><strong>Transaction ID:</strong> <?php echo htmlentities($trxIdShow); ?>
						<?php endif; ?>
					</div>
            
			</div>
		
			<div class="clearfix"></div>
	</div>
</div>
<!--- /contact ---->
<?php include('includes/footer.php');?>
<!-- sign -->
<?php include('includes/signup.php');?>	
<!-- signin -->
<?php include('includes/signin.php');?>	
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>	
<!-- //write us -->
</body>
</html>