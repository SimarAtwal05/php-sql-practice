<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "cms_project");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM admins WHERE username='$username'");
    $admin = $result->fetch_assoc();

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_id'] = $admin['id'];
        header("Location: admin.php");
    } else {
        echo "Invalid credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
</head>
<body>
    <form action="login.php" method="post">
        <label>Username: <input type="text" name="username"></label>
        <label>Password: <input type="password" name="password"></label>
        <button type="submit">Login</button>
    </form>
</body>
</html>
