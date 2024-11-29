<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

echo "Welcome, Admin!";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Menu</h2>
    <ul>
        <li><a href="manage_content.php">Manage Content</a></li>
        <li><a href="manage_admins.php">Manage Admins</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</body>
</html>
