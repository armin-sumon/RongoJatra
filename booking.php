<?php
session_start();
error_reporting(0);
include('includes/config.php');

$msg = "";
$error = "";
$createdBookingId = 0;
$totalAmount = 0;

if($_POST) {
    $package_id = $_POST['package_id'];
    $package_name = $_POST['package_name'];
    $package_price = $_POST['package_price'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $travelers = $_POST['travelers'];
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];
    $special_requests = $_POST['special_requests'];
    
    // Validate required fields
    if(empty($full_name) || empty($email) || empty($phone) || empty($travelers) || empty($from_date) || empty($to_date)) {
        $error = "Please fill in all required fields.";
    } else {
        // Validate email format
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            // Validate dates
            if(strtotime($from_date) >= strtotime($to_date)) {
                $error = "To date must be after from date.";
            } else {
                // Insert booking into database
                try {
                    $sql = "INSERT INTO tblbooking (PackageId, UserEmail, FromDate, ToDate, Comment, RegDate, status) VALUES (:package_id, :email, :from_date, :to_date, :comment, NOW(), 2)";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':package_id', $package_id, PDO::PARAM_STR);
                    $query->bindParam(':email', $email, PDO::PARAM_STR);
                    $query->bindParam(':from_date', $from_date, PDO::PARAM_STR);
                    $query->bindParam(':to_date', $to_date, PDO::PARAM_STR);
                    
                    // Create comment with all booking details
                    $comment = "Booking Details:\n";
                    $comment .= "Full Name: " . $full_name . "\n";
                    $comment .= "Phone: " . $phone . "\n";
                    $comment .= "Travelers: " . $travelers . "\n";
                    $comment .= "Package: " . $package_name . "\n";
                    $comment .= "Price: BDT " . $package_price . "\n";
                    if(!empty($special_requests)) {
                        $comment .= "Special Requests: " . $special_requests . "\n";
                    }
                    
                    $query->bindParam(':comment', $comment, PDO::PARAM_STR);
                    $query->execute();
                    
                    // Capture booking id and compute total for payment
                    $createdBookingId = (int)$dbh->lastInsertId();
                    $totalAmount = (float)$package_price * max(1, (int)$travelers);
                    
                    $msg = "Booking submitted successfully! Your booking is now pending admin approval. You can view and manage your booking status.";
                    
                } catch(PDOException $e) {
                    $error = "Database error: " . $e->getMessage();
                }
            }
        }
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
<title>Booking Confirmation - RongoJatra</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body>
<?php include('includes/header.php');?>

<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title text-center">Booking Confirmation</h3>
                </div>
                <div class="panel-body">
                    <?php if($error): ?>
                        <div class="alert alert-danger">
                            <strong>Error!</strong> <?php echo htmlentities($error); ?>
                        </div>
                        <div class="text-center">
                            <a href="javascript:history.back()" class="btn btn-primary">Go Back</a>
                        </div>
                    <?php elseif($msg): ?>
                        <div class="alert alert-success">
                            <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                        </div>
                        
                        <?php if($_POST): ?>
                        <div class="booking-summary">
                            <h4>Booking Summary</h4>
                            <table class="table table-bordered">
                                <tr>
                                    <td><strong>Package:</strong></td>
                                    <td><?php echo htmlentities($_POST['package_name']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Full Name:</strong></td>
                                    <td><?php echo htmlentities($_POST['full_name']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td><?php echo htmlentities($_POST['email']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Phone:</strong></td>
                                    <td><?php echo htmlentities($_POST['phone']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Travelers:</strong></td>
                                    <td><?php echo htmlentities($_POST['travelers']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>From Date:</strong></td>
                                    <td><?php echo htmlentities($_POST['from_date']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>To Date:</strong></td>
                                    <td><?php echo htmlentities($_POST['to_date']); ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>BDT <?php echo htmlentities($_POST['package_price']); ?></td>
                                </tr>
                            </table>
                        </div>
                        <?php endif; ?>
                        
                        <div class="text-center">
                            <a href="index.php" class="btn btn-primary">Back to Home</a>
                            <a href="my-bookings.php" class="btn btn-info">View My Bookings</a>
                            <a href="package-list.php" class="btn btn-success">View More Packages</a>
                        </div>
                        
                        <?php if($createdBookingId > 0): ?>
                        <hr>
                        <div class="text-center">
                            <p><strong>Test Payment — Demo Mode</strong><br>
                            No real money will be transferred. Admin can later Confirm or Cancel.</p>
                            <form action="testpay/create.php" method="post" style="display:inline-block;">
                                <input type="hidden" name="booking_id" value="<?php echo (int)$createdBookingId; ?>">
                                <input type="hidden" name="amount" value="<?php echo number_format($totalAmount, 2, '.', ''); ?>">
                                <input type="hidden" name="user_id" value="<?php echo isset($_SESSION['userid']) ? (int)$_SESSION['userid'] : 0; ?>">
                                <button type="submit" class="btn btn-warning">Proceed (BDT <?php echo number_format($totalAmount, 2); ?>)</button>
                            </form>
                        </div>
                        <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <strong>No booking data received.</strong>
                        </div>
                        <div class="text-center">
                            <a href="package-list.php" class="btn btn-primary">View Packages</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
</body>
</html>
