<?php
session_start();
error_reporting(0);
include('includes/config.php');

// No home enquiry form for logged-in users – use enquiry.php from header
?>
<!DOCTYPE HTML>
<html>
<head>
<title>RongoJatra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="applijewelleryion/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css?v=2" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<!-- Custom Theme files -->
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<!--animate-->
<!--<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script> -->
<!--//end-animate-->

<style>
.search-section {
    background: #f8f9fa;
    padding: 40px 20px;
    border-radius: 10px;
    margin: 20px 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.rupes-search-form .form-group {
    margin-bottom: 20px;
}

.rupes-search-form label {
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
    display: block;
}

.rupes-search-form .form-control {
    height: 45px;
    border: 2px solid #e9ecef;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}

.rupes-search-form .form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}

.search-btn {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
    padding: 15px 40px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,123,255,0.3);
}

.search-btn:hover {
    background: linear-gradient(45deg, #0056b3, #004085);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0,123,255,0.4);
}

.search-btn i {
    margin-right: 8px;
}
</style>
</head>
<body>



<?php include('includes/header.php');?>
<div class="banner-slideshow">
	<div class="slideshow-container">
		<div class="slide active" style="background-image: url('images/f1.jpg');"></div>
		<div class="slide" style="background-image: url('images/f2.jpg');"></div>
		<div class="slide" style="background-image: url('images/f3.jpg');"></div>
	</div>
</div>


<!--- rupes ---->
<div class="container">
	<div class="rupes">
		<div class="col-md-12 text-center">
			<div class="search-section wow fadeInUp animated" data-wow-delay=".5s">
				<h2 style="color: #333; margin-bottom: 30px;">Find Your Perfect Travel Package</h2>
				<form action="package-list.php" method="get" class="rupes-search-form">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label for="location">Destination</label>
								<input type="text" name="location" id="location" placeholder="Where do you want to go?" class="form-control" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="package_type">Package Type</label>
								<select name="package_type" id="package_type" class="form-control">
									<option value="">All Package Types</option>
									<option value="Family Package">Family Package</option>
									<option value="Couple Package">Couple Package</option>
									<option value="Group Package">Group Package</option>
									<option value="Adventure Package">Adventure Package</option>
								</select>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="price_range">Price Range</label>
								<select name="price_range" id="price_range" class="form-control">
									<option value="">Any Price</option>
									<option value="0-5000">BDT 0 - 5,000</option>
									<option value="5000-10000">BDT 5,000 - 10,000</option>
									<option value="10000-20000">BDT 10,000 - 20,000</option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 text-center">
							<button type="submit" class="btn btn-primary btn-lg search-btn">
								<i class="fa fa-search"></i> Search Packages
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<!--- /rupes ---->


<?php /* Home enquiry removed for logged-in users as requested */ ?>



<!---holiday---->
<div class="container">
	<div class="holiday">
	
	<h3>Package List</h3>

					
<?php $sql = "SELECT * from tbltourpackages order by rand() limit 4";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>
			<div class="rom-btm">
				<div class="col-md-3 room-left wow fadeInLeft animated" data-wow-delay=".5s">
					<img src="admin/pacakgeimages/<?php echo htmlentities($result->PackageImage);?>" class="img-responsive" alt="">
				</div>
				<div class="col-md-6 room-midle wow fadeInUp animated" data-wow-delay=".5s">
					<h4>Package Name: <?php echo htmlentities($result->PackageName);?></h4>
					<h6>Package Type : <?php echo htmlentities($result->PackageType);?></h6>
					<p><b>Package Location :</b> <?php echo htmlentities($result->PackageLocation);?></p>
					<p><b>Features</b> <?php echo htmlentities($result->PackageFetures);?></p>
				</div>
				<div class="col-md-3 room-right wow fadeInRight animated" data-wow-delay=".5s">
					<h5>BDT <?php echo htmlentities($result->PackagePrice);?></h5>
					<a href="package-details.php?pkgid=<?php echo htmlentities($result->PackageId);?>" class="view">Details</a>
				</div>
				<div class="clearfix"></div>
			</div>

<?php }} ?>
     
		
<div><a href="package-list.php" class="view">View More Packages</a></div>
</div>
			<div class="clearfix"></div>
	</div>



<!--- routes ---->
<div class="routes">
	<div class="container">
		<div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".5s">
			<div class="rou-left">
				<a href="#"><i class="glyphicon glyphicon-list-alt"></i></a>
			</div>
			<div class="rou-rgt wow fadeInDown animated" data-wow-delay=".5s">
				<h3 class="counter" data-count="80000">0</h3>
				<p>Enquiries</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 routes-left wow fadeInUp animated" data-wow-delay=".7s">
			<div class="rou-left">
				<a href="#"><i class="fa fa-user"></i></a>
			</div>
			<div class="rou-rgt">
				<h3 class="counter" data-count="1900">0</h3>
				<p>Regestered users</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="col-md-4 routes-left wow fadeInRight animated" data-wow-delay=".9s">
			<div class="rou-left">
				<a href="#"><i class="fa fa-ticket"></i></a>
			</div>
			<div class="rou-rgt">
				<h3 class="counter" data-count="70000000">0</h3>
				<p>Booking</p>
			</div>
				<div class="clearfix"></div>
		</div>
		<div class="clearfix"></div>
	</div>
</div>

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

<script>
// Animated counter function
function animateCounter(element, target, duration = 2000) {
    let start = 0;
    const increment = target / (duration / 16);
    
    function updateCounter() {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start).toLocaleString();
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target.toLocaleString();
        }
    }
    
    updateCounter();
}

// Slideshow functionality
function initSlideshow() {
    const slides = document.querySelectorAll('.slide');
    let currentSlide = 0;
    
    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }
    
    // Start slideshow - change every 7 seconds
    setInterval(nextSlide, 7000);
}

// Search image slideshow functionality
function initSearchImageSlideshow() {
    const searchSlides = document.querySelectorAll('.search-slide');
    let currentSearchSlide = 0;
    
    function showSearchSlide(index) {
        searchSlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
    }
    
    function nextSearchSlide() {
        currentSearchSlide = (currentSearchSlide + 1) % searchSlides.length;
        showSearchSlide(currentSearchSlide);
    }
    
    // Start search image slideshow - change every 5 seconds
    setInterval(nextSearchSlide, 5000);
}

// Initialize counters and slideshow when page loads
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        animateCounter(counter, target);
    });
    
    // Initialize slideshow
    initSlideshow();
    
    // Initialize search image slideshow
    initSearchImageSlideshow();
});
</script>
</body>
</html>