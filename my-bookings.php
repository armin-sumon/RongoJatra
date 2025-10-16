<?php
session_start();
error_reporting(0);
include('includes/config.php');

$msg = "";
$error = "";

// Handle booking cancellation by user
if(isset($_POST['cancel_booking'])) {
    $booking_id = $_POST['booking_id'];
    $cancellation_reason = $_POST['cancellation_reason'];
    
    try {
        $sql = "UPDATE tblbooking SET status = 0, CancelledBy = 'User', CancellationReason = :reason WHERE BookingId = :booking_id";
        $query = $dbh->prepare($sql);
        $query->bindParam(':reason', $cancellation_reason, PDO::PARAM_STR);
        $query->bindParam(':booking_id', $booking_id, PDO::PARAM_STR);
        $query->execute();
        
        $msg = "Booking cancelled successfully.";
    } catch(PDOException $e) {
        $error = "Error cancelling booking: " . $e->getMessage();
    }
}

// Handle sending chat message
if(isset($_POST['send_message'])) {
    $booking_id = $_POST['booking_id'];
    $message = $_POST['message'];
    
    try {
        $sql = "INSERT INTO tblchatmessages (BookingId, SenderType, Message) VALUES (:booking_id, 'user', :message)";
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
<title>My Bookings - RongoJatra</title>
<meta name="viewport" content="width=device-width, initial=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700,300' rel='stylesheet' type='text/css'>
<link href='//fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
.booking-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    padding: 20px;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}
.status-pending {
    color: #ffc107;
    font-weight: bold;
}
.status-confirmed {
    color: #28a745;
    font-weight: bold;
}
.status-cancelled {
    color: #dc3545;
    font-weight: bold;
}
.chat-container {
    max-height: 300px;
    overflow-y: auto;
    border: 1px solid #ddd;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 5px;
}
.message {
    margin-bottom: 10px;
    padding: 8px 12px;
    border-radius: 5px;
}
.message.user {
    background: #007bff;
    color: white;
    margin-left: 20%;
}
.message.admin {
    background: #6c757d;
    color: white;
    margin-right: 20%;
}
.message-time {
    font-size: 0.8em;
    opacity: 0.7;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>

<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="row">
        <div class="col-md-12">
            <h2>My Bookings</h2>
            <p>View and manage your travel bookings.</p>
            
            <?php if($error): ?>
                <div class="alert alert-danger">
                    <strong>Error!</strong> <?php echo htmlentities($error); ?>
                </div>
            <?php elseif($msg): ?>
                <div class="alert alert-success">
                    <strong>Success!</strong> <?php echo htmlentities($msg); ?>
                </div>
            <?php endif; ?>
            
            <?php
            // Get user's email from session or form
            $user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : '';
            
            if(empty($user_email)) {
                // Show email input form
            ?>
            <div class="alert alert-info">
                <h4>Enter Your Email to View Bookings</h4>
                <form method="get" class="form-inline">
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email address" required>
                    </div>
                    <button type="submit" class="btn btn-primary">View My Bookings</button>
                </form>
            </div>
            <?php
            } else {
                $user_email = $_GET['email'] ?? $user_email;
                
                $sql = "SELECT b.*, p.PackageName, p.PackageType, p.PackageLocation, p.PackagePrice 
                        FROM tblbooking b 
                        LEFT JOIN tbltourpackages p ON b.PackageId = p.PackageId 
                        WHERE b.UserEmail = :email 
                        ORDER BY b.RegDate DESC";
                $query = $dbh->prepare($sql);
                $query->bindParam(':email', $user_email, PDO::PARAM_STR);
                $query->execute();
                $results = $query->fetchAll(PDO::FETCH_OBJ);
                
                if($query->rowCount() > 0) {
                    foreach($results as $result) {
                        $status_class = '';
                        $status_text = '';
                        switch($result->status) {
                            case 0:
                                $status_class = 'status-cancelled';
                                $status_text = 'Cancelled';
                                break;
                            case 1:
                                $status_class = 'status-confirmed';
                                $status_text = 'Confirmed';
                                break;
                            case 2:
                                $status_class = 'status-pending';
                                $status_text = 'Pending';
                                break;
                        }
            ?>
            <div class="booking-card">
                <div class="row">
                    <div class="col-md-8">
                        <h4><?php echo htmlentities($result->PackageName); ?></h4>
                        <p><strong>Type:</strong> <?php echo htmlentities($result->PackageType); ?></p>
                        <p><strong>Location:</strong> <?php echo htmlentities($result->PackageLocation); ?></p>
                        <p><strong>Price:</strong> BDT <?php echo htmlentities($result->PackagePrice); ?></p>
                        <p><strong>From:</strong> <?php echo htmlentities($result->FromDate); ?> <strong>To:</strong> <?php echo htmlentities($result->ToDate); ?></p>
                        <p><strong>Booking Date:</strong> <?php echo date('d M Y, H:i', strtotime($result->RegDate)); ?></p>
                        <p><strong>Status:</strong> <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span></p>
                        
                        <?php if($result->CancellationReason): ?>
                        <p><strong>Cancellation Reason:</strong> <?php echo htmlentities($result->CancellationReason); ?></p>
                        <?php endif; ?>
                        
                        <?php if($result->AdminRemark): ?>
                        <p><strong>Admin Remark:</strong> <?php echo htmlentities($result->AdminRemark); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-4">
                        <?php if($result->status == 2): // Pending ?>
                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelModal<?php echo $result->BookingId; ?>">
                            Cancel Booking
                        </button>
                        <?php elseif($result->status == 1): // Confirmed ?>
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#chatModal<?php echo $result->BookingId; ?>">
                            Open Chat
                        </button>
                        <?php endif; ?>
                        
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo $result->BookingId; ?>">
                            View Details
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Cancel Booking Modal -->
            <?php if($result->status == 2): ?>
            <div class="modal fade" id="cancelModal<?php echo $result->BookingId; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Cancel Booking</h4>
                        </div>
                        <form method="post">
                            <div class="modal-body">
                                <input type="hidden" name="booking_id" value="<?php echo $result->BookingId; ?>">
                                <p>Are you sure you want to cancel this booking?</p>
                                <div class="form-group">
                                    <label for="cancellation_reason">Reason for cancellation:</label>
                                    <textarea name="cancellation_reason" class="form-control" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No, Keep Booking</button>
                                <button type="submit" name="cancel_booking" class="btn btn-danger">Yes, Cancel Booking</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Chat Modal -->
            <?php if($result->status == 1): ?>
            <div class="modal fade" id="chatModal<?php echo $result->BookingId; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Chat - Booking #<?php echo $result->BookingId; ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="chat-container" id="chatMessages<?php echo $result->BookingId; ?>">
                                <?php
                                // Get chat messages
                                $chat_sql = "SELECT * FROM tblchatmessages WHERE BookingId = :booking_id ORDER BY MessageDate ASC";
                                $chat_query = $dbh->prepare($chat_sql);
                                $chat_query->bindParam(':booking_id', $result->BookingId, PDO::PARAM_STR);
                                $chat_query->execute();
                                $chat_results = $chat_query->fetchAll(PDO::FETCH_OBJ);
                                
                                foreach($chat_results as $chat_msg) {
                                    $message_class = ($chat_msg->SenderType == 'user') ? 'user' : 'admin';
                                    echo '<div class="message ' . $message_class . '">';
                                    echo '<div>' . htmlentities($chat_msg->Message) . '</div>';
                                    echo '<div class="message-time">' . date('d M Y, H:i', strtotime($chat_msg->MessageDate)) . '</div>';
                                    echo '</div>';
                                }
                                ?>
                            </div>
                            <form method="post" style="margin-top: 15px;">
                                <input type="hidden" name="booking_id" value="<?php echo $result->BookingId; ?>">
                                <div class="form-group">
                                    <textarea name="message" class="form-control" rows="3" placeholder="Type your message..." required></textarea>
                                </div>
                                <button type="submit" name="send_message" class="btn btn-primary">Send Message</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
            <!-- Details Modal -->
            <div class="modal fade" id="detailsModal<?php echo $result->BookingId; ?>" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Booking Details - ID: <?php echo $result->BookingId; ?></h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><strong>Customer Information</strong></h5>
                                    <p><strong>Email:</strong> <?php echo htmlentities($result->UserEmail); ?></p>
                                    <p><strong>Booking Date:</strong> <?php echo date('d M Y, H:i', strtotime($result->RegDate)); ?></p>
                                    <p><strong>Status:</strong> <span class="<?php echo $status_class; ?>"><?php echo $status_text; ?></span></p>
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
                                    <h5><strong>Additional Information</strong></h5>
                                    <div style="background: #f8f9fa; padding: 15px; border-radius: 5px;">
                                        <pre style="white-space: pre-wrap; font-family: inherit; margin: 0;"><?php echo htmlentities($result->Comment); ?></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                } else {
            ?>
            <div class="alert alert-info">
                <strong>No bookings found.</strong> You haven't made any bookings yet.
            </div>
            <?php
                }
            }
            ?>
            
            <div class="text-center" style="margin-top: 30px;">
                <a href="index.php" class="btn btn-primary">Back to Home</a>
                <a href="package-list.php" class="btn btn-success">View Packages</a>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
</body>
</html>
