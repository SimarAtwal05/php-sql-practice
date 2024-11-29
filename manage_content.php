<?php
session_start();
$conn = new mysqli("localhost", "username", "password", "cms_project");

// Redirect to login if not authenticated
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// Create Subject
if (isset($_POST['add_subject'])) {
    $menu_name = $_POST['menu_name'];
    $position = $_POST['position'];
    $visible = $_POST['visible'];

    $stmt = $conn->prepare("INSERT INTO subjects (menu_name, position, visible) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $menu_name, $position, $visible);
    $stmt->execute();
    header("Location: manage_content.php");
}

// Update Subject
if (isset($_POST['edit_subject'])) {
    $id = $_POST['id'];
    $menu_name = $_POST['menu_name'];
    $position = $_POST['position'];
    $visible = $_POST['visible'];

    $stmt = $conn->prepare("UPDATE subjects SET menu_name=?, position=?, visible=? WHERE id=?");
    $stmt->bind_param("siii", $menu_name, $position, $visible, $id);
    $stmt->execute();
    header("Location: manage_content.php");
}

// Delete Subject
if (isset($_GET['delete_subject'])) {
    $id = $_GET['delete_subject'];
    $stmt = $conn->prepare("DELETE FROM subjects WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: manage_content.php");
}

// Fetch all subjects
$subjects_query = "SELECT * FROM subjects ORDER BY position ASC";
$subjects = $conn->query($subjects_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Content</title>
</head>
<body>
    <h2>Manage Content</h2>
    
    <!-- Display all subjects with Edit and Delete options -->
    <ul>
        <?php while ($subject = $subjects->fetch_assoc()): ?>
            <li><?= $subject['menu_name'] ?> - Position: <?= $subject['position'] ?> - Visible: <?= $subject['visible'] ?>
                <a href="edit_subject.php?id=<?= $subject['id'] ?>">Edit</a>
                <a href="manage_content.php?delete_subject=<?= $subject['id'] ?>" onclick="return confirm('Are you sure?');">Delete</a>
            </li>
        <?php endwhile; ?>
    </ul>

    <!-- Add New Subject Form -->
    <h3>Add New Subject</h3>
    <form action="manage_content.php" method="post">
        <input type="hidden" name="add_subject" value="1">
        <label>Menu Name: <input type="text" name="menu_name" required></label>
        <label>Position: <input type="number" name="position" required></label>
        <label>Visible: <input type="checkbox" name="visible" value="1"></label>
        <button type="submit">Add Subject</button>
    </form>
</body>
</html>
