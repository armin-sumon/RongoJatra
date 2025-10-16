<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<title>View Bookings - RongoJatra Admin</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link href="css/font-awesome.css" rel="stylesheet">
<script src="js/jquery-1.12.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<style>
.booking-table {
    margin-top: 30px;
}
.booking-table th {
    background-color: #007bff;
    color: white;
    padding: 12px;
}
.booking-table td {
    padding: 10px;
    border: 1px solid #ddd;
}
.status-active {
    color: #28a745;
    font-weight: bold;
}
.status-cancelled {
    color: #dc3545;
    font-weight: bold;
}
</style>
</head>
<body>
<?php include('includes/header.php');?>

<div class="container booking-table">
    <div class="row">
        <div class="col-md-12">
            <h2>All Bookings</h2>
            <p>View all customer bookings and their details.</p>
            
            <?php
            $sql = "SELECT b.*, p.PackageName, p.PackageType, p.PackageLocation, p.PackagePrice 
                    FROM tblbooking b 
                    LEFT JOIN tbltourpackages p ON b.PackageId = p.PackageId 
                    ORDER BY b.RegDate DESC";
            $query = $dbh->prepare($sql);
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_OBJ);
            
            if($query->rowCount() > 0) {
            ?>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Customer Email</th>
                            <th>Package</th>
                            <th>From Date</th>
                            <th>To Date</th>
                            <th>Booking Date</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($results as $result) {
                            $status_class = ($result->status == 1) ? 'status-active' : 'status-cancelled';
                            $status_text = ($result->status == 1) ? 'Active' : 'Cancelled';
                        ?>
                        <tr>
                            <td><?php echo htmlentities($result->BookingId); ?></td>
                            <td><?php echo htmlentities($result->UserEmail); ?></td>
                            <td>
                                <strong><?php echo htmlentities($result->PackageName); ?></strong><br>
                                <small><?php echo htmlentities($result->PackageType); ?></small><br>
                                <small><?php echo htmlentities($result->PackageLocation); ?></small>
                            </td>
                            <td><?php echo htmlentities($result->FromDate); ?></td>
                            <td><?php echo htmlentities($result->ToDate); ?></td>
                            <td><?php echo date('d M Y, H:i', strtotime($result->RegDate)); ?></td>
                            <td class="<?php echo $status_class; ?>"><?php echo $status_text; ?></td>
                            <td>
                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailsModal<?php echo $result->BookingId; ?>">
                                    View Details
                                </button>
                            </td>
                        </tr>
                        
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
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php } else { ?>
            <div class="alert alert-info">
                <strong>No bookings found.</strong> No customers have made any bookings yet.
            </div>
            <?php } ?>
            
            <div class="text-center" style="margin-top: 30px;">
                <a href="admin/index.php" class="btn btn-primary">Go to Admin Panel</a>
                <a href="index.php" class="btn btn-success">Back to Home</a>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php');?>
</body>
</html>
