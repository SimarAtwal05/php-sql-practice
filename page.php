<?php
// Connect to database
$conn = new mysqli("localhost", "username", "password", "cms_project");

$subject_id = $_GET['subject_id'];

// Fetch pages for the selected subject
$page_query = "SELECT * FROM pages WHERE subject_id = $subject_id AND visible = 1 ORDER BY position ASC";
$pages = $conn->query($page_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Widget Corp - Pages</title>
</head>
<body>
    <header>
        <h1>Widget Corp</h1>
    </header>

    <section>
        <?php while ($page = $pages->fetch_assoc()): ?>
            <article>
                <h2><?= $page['menu_name'] ?></h2>
                <p><?= $page['content'] ?></p>
            </article>
        <?php endwhile; ?>
    </section>
</body>
</html>
