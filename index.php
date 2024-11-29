<?php
// Connect to database
$conn = new mysqli("localhost", "username", "password", "cms_project");

// Fetch subjects for the navigation menu
$subject_query = "SELECT * FROM subjects WHERE visible = 1 ORDER BY position ASC";
$subjects = $conn->query($subject_query);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Widget Corp</title>
</head>
<body>
    <header>
        <h1>Widget Corp</h1>
    </header>

    <nav>
        <ul>
            <?php while ($subject = $subjects->fetch_assoc()): ?>
                <li><a href="page.php?subject_id=<?= $subject['id'] ?>"><?= $subject['menu_name'] ?></a></li>
            <?php endwhile; ?>
        </ul>
    </nav>

    <section>
        <h2>Welcome to Widget Corp!</h2>
        <p>Select a subject to view its content.</p>
    </section>
</body>
</html>
