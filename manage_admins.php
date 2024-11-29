<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "cms_project");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Create Admin
if (isset($_POST['add_admin'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    header("Location: manage_admins.php");
}

// Delete Admin
if (isset($_GET['delete_admin'])) {
    $id = $_GET['delete_admin'];
    $stmt = $conn->prepare("DELETE FROM admins WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_admins.php");
}

// Fetch all admins
$admins_query = "SELECT * FROM admins";
$admins = $conn->query($admins_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Admins</title>
</head>
<body>
    <h2>Manage Admins</h2>

    <!-- Display all admins with Delete option -->
    <ul>
        <?php while ($admin = $admins->fetch_assoc()): ?>
            <li><?= $admin['username'] ?>
                <a href="manage_admins.php?delete_admin=<?= $admin['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Add New Admin Form -->
    <h3>Add New Admin</h3>
    <form action="manage_admins.php" method="post">
        <input type="hidden" name="add_admin" value="1">
        <label>Username: <input type="text" name="username" required></label>
        <label>Password: <input type="password" name="password" required></label>
        <button type="submit">Add Admin</button>
    </form>
</body>
</html>
