<?php
session_start();
error_reporting(0);
include('includes/config.php');
$pid=intval($_GET['pkgid']);
?>
<!DOCTYPE HTML>
<html>
<head>
<title>RongoJatra - Package Details</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
<style>
.image-gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    margin: 20px 0;
}
.image-gallery img {
    width: 300px;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}
.package-main-image {
    width: 100%;
    max-width: 400px;
    height: 250px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.image-gallery img:hover {
    transform: scale(1.05);
}
.package-details {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 10px;
    margin: 20px 0;
}
</style>
</head>
<body>
<?php include('includes/header.php');?> 
<!--- banner ---->
<div class="banner-3">
	<div class="container">
		<h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;"> RongoJatra - Package Details</h1>
	</div>
</div>
<!--- /banner ---->

<?php 
$sql = "SELECT * from tbltourpackages where PackageId=:pid";
$query = $dbh->prepare($sql);
$query->bindParam(':pid',$pid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
<!--- package details ---->
<div class="package-details">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h2><?php echo htmlentities($result->PackageName);?></h2>
				<h4>Package Type: <?php echo htmlentities($result->PackageType);?></h4>
				<p><strong>Location:</strong> <?php echo htmlentities($result->PackageLocation);?></p>
				<p><strong>Price:</strong> BDT <?php echo htmlentities($result->PackagePrice);?></p>
				<p><strong>Features:</strong> <?php echo htmlentities($result->PackageFetures);?></p>
				<p><strong>Details:</strong> <?php echo htmlentities($result->PackageDetails);?></p>
			</div>
			<div class="col-md-4">
				<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="package-main-image" alt="">
			</div>
		</div>
		
		<?php if($result->PackageName == "Cox's Bazar") { ?>
		<!-- Special image gallery for Cox's Bazar -->
		<div class="image-gallery">
			<h3>More Images of Cox's Bazar</h3>
			<img src="images/1.jpg" alt="Cox's Bazar Image 1" class="img-responsive">
			<img src="images/103.jpeg" alt="Cox's Bazar Image 2" class="img-responsive">
			<img src="images/114.jpeg" alt="Cox's Bazar Image 3" class="img-responsive">
		</div>
		<?php } ?>
		
		<div class="row" style="margin-top: 30px;">
			<div class="col-md-12 text-center">
				<a href="package-list.php" class="btn btn-primary">Back to Package List</a>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#bookingModal">Book Now</button>
			</div>
		</div>
	</div>
</div>
<!--- /package details ---->
<?php }} else { ?>
<div class="container">
	<div class="alert alert-warning">
		<h3>Package Not Found</h3>
		<p>The requested package could not be found.</p>
		<a href="package-list.php" class="btn btn-primary">Back to Package List</a>
	</div>
</div>
<?php } ?>

<!--- /footer-top ---->
<?php include('includes/footer.php');?>
<!-- signup -->
<?php include('includes/signup.php');?>			
<!-- //signu -->
<!-- signin -->
<?php include('includes/signin.php');?>			
<!-- //signin -->
<!-- write us -->
<?php include('includes/write-us.php');?>			
<!-- //write us -->

<!-- Booking Modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="bookingModalLabel">Book Package: <?php echo htmlentities($result->PackageName);?></h4>
            </div>
            <div class="modal-body">
                <form id="bookingForm" method="post" action="booking.php">
                    <input type="hidden" name="package_id" value="<?php echo htmlentities($result->PackageId);?>">
                    <input type="hidden" name="package_name" value="<?php echo htmlentities($result->PackageName);?>">
                    <input type="hidden" name="package_price" value="<?php echo htmlentities($result->PackagePrice);?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="full_name">Full Name *</label>
                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="travelers">Number of Travelers *</label>
                                <select class="form-control" id="travelers" name="travelers" required>
                                    <option value="">Select Travelers</option>
                                    <option value="1">1 Person</option>
                                    <option value="2">2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                    <option value="5">5 People</option>
                                    <option value="6+">6+ People</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="from_date">From Date *</label>
                                <input type="date" class="form-control" id="from_date" name="from_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="to_date">To Date *</label>
                                <input type="date" class="form-control" id="to_date" name="to_date" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="special_requests">Special Requests or Comments</label>
                        <textarea class="form-control" id="special_requests" name="special_requests" rows="3" placeholder="Any special requirements or comments..."></textarea>
                    </div>
                    
                    <div class="alert alert-info">
                        <strong>Package Details:</strong><br>
                        <strong>Package:</strong> <?php echo htmlentities($result->PackageName);?><br>
                        <strong>Type:</strong> <?php echo htmlentities($result->PackageType);?><br>
                        <strong>Location:</strong> <?php echo htmlentities($result->PackageLocation);?><br>
                        <strong>Price:</strong> BDT <?php echo htmlentities($result->PackagePrice);?>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" form="bookingForm" class="btn btn-success">Confirm Booking</button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
