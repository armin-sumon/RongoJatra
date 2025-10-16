<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Corporate Services - RongoJatra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
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
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
	<script>
		 new WOW().init();
	</script>
<!--//end-animate-->
<style>
.corporate-header {
    background: url('images/Corporate.png') center/cover no-repeat;
    background-size: cover;
    background-position: center center;
    width: 100%;
    height: 400px;
    position: relative;
    overflow: hidden;
}

.service-grid {
    padding: 60px 0;
    background: #f5f5f5;
}

.service-item {
    text-align: left;
    padding: 25px 20px;
    margin-bottom: 20px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    min-height: 160px;
    border: 1px solid #e9ecef;
    height: 100%;
}

.service-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.service-item.special-card {
    background: #e3f2fd;
    border: 1px solid #bbdefb;
}

.service-grid .row {
    margin: 0;
}

.service-grid .col-md-4 {
    padding: 0 10px;
    margin-bottom: 20px;
}

.service-icon {
    font-size: 2.2rem;
    color: #000;
    margin-bottom: 20px;
    display: inline-block;
}

.service-title {
    font-size: 1.2rem;
    font-weight: bold;
    color: #333;
    margin-bottom: 12px;
    line-height: 1.3;
}

    .service-description {
        color: #666;
        line-height: 1.5;
        font-size: 0.9rem;
    }

    /* Statistics Section */
    .stats-section {
        background: white;
        padding: 60px 0;
    }

    .stat-item {
        text-align: center;
        padding: 20px;
    }

    .stat-icon {
        font-size: 3rem;
        color: #007bff;
        margin-bottom: 15px;
        display: block;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #28a745;
        margin-bottom: 10px;
        display: block;
    }

    .stat-label {
        color: #666;
        font-size: 1.1rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

.main-content {
    background: white;
    padding: 60px 0;
}

.content-title {
    font-size: 2.5rem;
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    font-weight: bold;
}

.content-description {
    font-size: 1.1rem;
    color: #666;
    line-height: 1.8;
    text-align: center;
    max-width: 800px;
    margin: 0 auto 50px;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>

<!-- Corporate Header Section -->
<div class="corporate-header">
    <!-- No text content - just the background image -->
</div>

<!-- Main Content Section -->
<div class="main-content">
    <div class="container">
        <h2 class="content-title wow fadeInUp animated" data-wow-delay=".5s">Our Corporate Travel Services</h2>
        <p class="content-description wow fadeInUp animated" data-wow-delay=".7s">
            At RongoJatra, we specialize in crafting personalized travel and event experiences for corporate clients across Bangladesh and globally. From annual sales conferences and team retreats to AGMs and incentive trips, we take care of everything. Whether you're planning a strategy retreat or celebrating your team, our experts will ensure it's smooth, memorable, and impactful. Our services include:
        </p>
    </div>
</div>

<!-- Services Grid -->
<div class="service-grid">
    <div class="container">
        <div class="row">
            <!-- First Row -->
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay=".5s">
                    <div class="service-icon">
                        <i class="fa fa-globe" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Domestic & International Tour Packages</h3>
                    <p class="service-description">Tailored travel solutions for your corporate team—whether exploring Bangladesh or traveling worldwide.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay=".7s">
                    <div class="service-icon">
                        <i class="fa fa-building" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Hotel and Venue Bookings</h3>
                    <p class="service-description">Seamless reservations for accommodations and event venues to ensure comfort and convenience.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item special-card wow fadeInUp animated" data-wow-delay=".9s">
                    <div class="service-icon">
                        <i class="fa fa-bus" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Transport & Airport Transfers</h3>
                    <p class="service-description">Hassle-free ground transport and airport transfers for executives and teams.</p>
                </div>
            </div>
        </div>
        
        <div class="row">
            <!-- Second Row -->
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.1s">
                    <div class="service-icon">
                        <i class="fa fa-users" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Team Building Activities & Excursions</h3>
                    <p class="service-description">Engaging activities and outings designed to strengthen teamwork and morale.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.3s">
                    <div class="service-icon">
                        <i class="fa fa-calendar-plus-o" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">Event Management & Gala Dinners</h3>
                    <p class="service-description">Comprehensive planning and coordination for conferences, AGMs, and memorable corporate events.</p>
                </div>
            </div>
            
            <div class="col-md-4 col-sm-6">
                <div class="service-item wow fadeInUp animated" data-wow-delay="1.5s">
                    <div class="service-icon">
                        <i class="fa fa-headphones" style="color: #000;"></i>
                    </div>
                    <h3 class="service-title">24/7 Dedicated Support Team & Onsite Travel Desks</h3>
                    <p class="service-description">Around-the-clock assistance and onsite travel desks for large organizations.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".5s">
                    <i class="fa fa-list-alt stat-icon"></i>
                    <span class="stat-number" data-count="80000">0</span>
                    <div class="stat-label">Enquiries</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".7s">
                    <i class="fa fa-user stat-icon"></i>
                    <span class="stat-number" data-count="1900">0</span>
                    <div class="stat-label">Registered Users</div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-item wow fadeInUp animated" data-wow-delay=".9s">
                    <i class="fa fa-ticket stat-icon"></i>
                    <span class="stat-number" data-count="70000000">0</span>
                    <div class="stat-label">Booking</div>
                </div>
            </div>
        </div>
    </div>
</div>

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

// Initialize counters when page loads
document.addEventListener('DOMContentLoaded', function() {
    const counters = document.querySelectorAll('.stat-number');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-count'));
        animateCounter(counter, target);
    });
});
</script>

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
</body>
</html>
