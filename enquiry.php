<?php
session_start();
error_reporting(0);
include('includes/config.php');

$msg = "";
$error = "";

if(isset($_POST['submit']))
{
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Validate required fields
    if(empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
        $error = "Please fill in all required fields.";
    } else {
        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            // Insert enquiry into database
            try {
                $sql = "INSERT INTO tblenquiry (FullName, EmailId, MobileNumber, Subject, Description, PostingDate, Status) VALUES (:name, :email, :phone, :subject, :message, NOW(), 0)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':name', $name, PDO::PARAM_STR);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->bindParam(':phone', $phone, PDO::PARAM_STR);
                $query->bindParam(':subject', $subject, PDO::PARAM_STR);
                $query->bindParam(':message', $message, PDO::PARAM_STR);
                $query->execute();
                
                $msg = "Your enquiry has been submitted successfully! We will contact you soon.";
                
            } catch(PDOException $e) {
                $error = "Database error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Enquiry - RongoJatra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
<script src="js/wow.min.js"></script>
<script>
    new WOW().init();
</script>
<style>
.enquiry-section {
    background: #f8f9fa;
    padding: 60px 0;
}
.enquiry-form {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}
.form-group {
    margin-bottom: 20px;
}
.form-group label {
    font-weight: bold;
    color: #333;
    margin-bottom: 8px;
    display: block;
}
.form-control {
    height: 45px;
    border: 2px solid #e9ecef;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s ease;
}
.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
}
textarea.form-control {
    height: auto;
    min-height: 120px;
}
.submit-btn {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    padding: 15px 40px;
    font-size: 16px;
    font-weight: bold;
    border-radius: 25px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(40,167,69,0.3);
}
.submit-btn:hover {
    background: linear-gradient(45deg, #20c997, #17a2b8);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40,167,69,0.4);
}
.contact-info {
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    height: 100%;
}
.contact-item {
    margin-bottom: 30px;
    text-align: center;
}
.contact-item i {
    font-size: 2.5rem;
    color: #007bff;
    margin-bottom: 15px;
}
.contact-item h4 {
    color: #333;
    margin-bottom: 10px;
}
.contact-item p {
    color: #666;
    margin: 0;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>

<!-- Banner Section -->
<div class="banner-3">
    <div class="container">
        <h1 class="wow zoomIn animated animated" data-wow-delay=".5s" style="visibility: visible; animation-delay: 0.5s; animation-name: zoomIn;">Enquiry - RongoJatra</h1>
    </div>
</div>

<!-- Enquiry Section -->
<div class="enquiry-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="enquiry-form">
                    <h2 style="color: #333; margin-bottom: 30px; text-align: center;">Send Us Your Enquiry</h2>
                    
                    <?php if($error): ?>
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                        </div>
                    <?php elseif($msg): ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="post" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name *</label>
                                    <input type="text" class="form-control" id="name" name="name" required>
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
                                    <label for="subject">Subject *</label>
                                    <select class="form-control" id="subject" name="subject" required>
                                        <option value="">Select Subject</option>
                                        <option value="General Inquiry">General Inquiry</option>
                                        <option value="Package Information">Package Information</option>
                                        <option value="Booking Assistance">Booking Assistance</option>
                                        <option value="Cancellation">Cancellation</option>
                                        <option value="Refund">Refund</option>
                                        <option value="Corporate Travel">Corporate Travel</option>
                                        <option value="Group Booking">Group Booking</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Please describe your enquiry in detail..." required></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success btn-lg submit-btn">
                                <i class="fa fa-paper-plane"></i> Send Enquiry
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="contact-info">
                    <h3 style="color: #333; margin-bottom: 30px; text-align: center;">Contact Information</h3>
                    
                    <div class="contact-item">
                        <i class="fa fa-phone"></i>
                        <h4>Phone</h4>
                        <p>+880 16249</p>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fa fa-envelope"></i>
                        <h4>Email</h4>
                        <p>info@rongojatra.com</p>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fa fa-clock-o"></i>
                        <h4>Business Hours</h4>
                        <p>24/7 Customer Support</p>
                    </div>
                    
                    <div class="contact-item">
                        <i class="fa fa-map-marker"></i>
                        <h4>Location</h4>
                        <p>Dhaka, Bangladesh</p>
                    </div>
                </div>
            </div>
        </div>
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
</body>
</html>
