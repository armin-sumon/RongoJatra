<?php
// Fix admin login - Reset admin password
include('includes/config.php');

echo "<h2>Fixing Admin Login...</h2>";

try {
    // Reset admin password to 'admin123'
    $username = 'admin';
    $password = md5('admin123');
    
    $sql = "UPDATE admin SET Password = :password WHERE UserName = :username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':password', $password, PDO::PARAM_STR);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();
    
    if($query->rowCount() > 0) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>✅ Success!</strong> Admin password has been reset!<br>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Password:</strong> admin123<br>";
        echo "<strong>MD5 Hash:</strong> " . $password;
        echo "</div>";
    } else {
        // Create admin account if it doesn't exist
        $sql = "INSERT INTO admin (UserName, Password, updationDate) VALUES (:username, :password, NOW())";
        $query = $dbh->prepare($sql);
        $query->bindParam(':username', $username, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
        echo "<strong>✅ Success!</strong> Admin account has been created!<br>";
        echo "<strong>Username:</strong> admin<br>";
        echo "<strong>Password:</strong> admin123<br>";
        echo "<strong>MD5 Hash:</strong> " . $password;
        echo "</div>";
    }
    
    // Also ensure cse471 account works
    $username2 = 'cse471';
    $password2 = md5('12345');
    
    $sql = "UPDATE admin SET Password = :password WHERE UserName = :username";
    $query = $dbh->prepare($sql);
    $query->bindParam(':password', $password2, PDO::PARAM_STR);
    $query->bindParam(':username', $username2, PDO::PARAM_STR);
    $query->execute();
    
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<strong>✅ Also Fixed!</strong> Second admin account ready!<br>";
    echo "<strong>Username:</strong> cse471<br>";
    echo "<strong>Password:</strong> 12345<br>";
    echo "<strong>MD5 Hash:</strong> " . $password2;
    echo "</div>";
    
} catch(PDOException $e) {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
    echo "<strong>❌ Error:</strong> " . $e->getMessage();
    echo "</div>";
}

echo "<div style='background: #cce5ff; color: #004085; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
echo "<h3>🔑 Login Credentials:</h3>";
echo "<p><strong>Option 1:</strong> Username: <code>admin</code> | Password: <code>admin123</code></p>";
echo "<p><strong>Option 2:</strong> Username: <code>cse471</code> | Password: <code>12345</code></p>";
echo "<p><a href='admin/index.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>🚀 Go to Admin Login</a></p>";
echo "</div>";
?>
