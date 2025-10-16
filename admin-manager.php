<?php
// Quick admin account creator
include('includes/config.php');

echo "<h2>Admin Account Manager</h2>";

// Check current admin accounts
echo "<h3>Current Admin Accounts:</h3>";
$sql = "SELECT * FROM admin";
$query = $dbh->prepare($sql);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

if($query->rowCount() > 0) {
    echo "<table border='1' style='border-collapse: collapse; margin: 20px 0;'>";
    echo "<tr><th>ID</th><th>Username</th><th>Password Hash</th><th>Update Date</th></tr>";
    foreach($results as $result) {
        echo "<tr>";
        echo "<td>" . $result->id . "</td>";
        echo "<td>" . $result->UserName . "</td>";
        echo "<td>" . $result->Password . "</td>";
        echo "<td>" . $result->updationDate . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No admin accounts found!</p>";
}

// Create new admin account
if(isset($_POST['create_admin'])) {
    $username = $_POST['username'];
    $password = md5($_POST['password']);
    
    try {
        $sql = "INSERT INTO admin (UserName, Password, updationDate) VALUES (:username, :password, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>Success!</strong> Admin account created successfully!<br>";
        echo "<strong>Username:</strong> " . htmlentities($username) . "<br>";
        echo "<strong>Password:</strong> " . htmlentities($_POST['password']);
        echo "</div>";
        
    } catch(PDOException $e) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>Error:</strong> " . $e->getMessage();
        echo "</div>";
    }
}

// Reset admin password
if(isset($_POST['reset_password'])) {
    $username = $_POST['reset_username'];
    $new_password = md5($_POST['new_password']);
    
    try {
        $sql = "UPDATE admin SET Password = :password, updationDate = NOW() WHERE UserName = :username";
        $query = $dbh->prepare($sql);
        $query->bindParam(':password', $new_password, PDO::PARAM_STR);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->execute();
        
        if($query->rowCount() > 0) {
            echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
            echo "<strong>Success!</strong> Password updated for user: " . htmlentities($username);
            echo "</div>";
        } else {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
            echo "<strong>Error:</strong> User not found: " . htmlentities($username);
            echo "</div>";
        }
        
    } catch(PDOException $e) {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>Error:</strong> " . $e->getMessage();
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Account Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-group { margin: 15px 0; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input[type="text"], input[type="password"] { padding: 8px; width: 200px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #0056b3; }
        .section { border: 1px solid #ddd; padding: 20px; margin: 20px 0; border-radius: 5px; }
    </style>
</head>
<body>

<div class="section">
    <h3>Create New Admin Account</h3>
    <form method="post">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="username" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit" name="create_admin">Create Admin Account</button>
    </form>
</div>

<div class="section">
    <h3>Reset Admin Password</h3>
    <form method="post">
        <div class="form-group">
            <label>Username:</label>
            <input type="text" name="reset_username" required>
        </div>
        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="new_password" required>
        </div>
        <button type="submit" name="reset_password">Reset Password</button>
    </form>
</div>

<div class="section">
    <h3>Quick Login Test</h3>
    <p><strong>Try these credentials:</strong></p>
    <ul>
        <li><strong>Username:</strong> admin | <strong>Password:</strong> admin123</li>
        <li><strong>Username:</strong> cse471 | <strong>Password:</strong> 12345</li>
    </ul>
    <p><a href="admin/index.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Go to Admin Login</a></p>
</div>

</body>
</html>
