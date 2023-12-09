<?php
$successMessage = "";
$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = mysqli_connect("localhost", "root", "", "db_blog");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['name'])) : '';
    $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['email'])) : '';
    $topic = isset($_POST['topic']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['topic'])) : '';
    $blog = isset($_POST['blog']) ? mysqli_real_escape_string($conn, htmlspecialchars($_POST['blog'])) : '';

    $insertQuery = "INSERT INTO tbl_story (name, email, topic, blog) VALUES ('$name', '$email', '$topic', '$blog')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        $successMessage = "Entry added successfully.";
    } else {
        $errorMessage = "Error: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}

$conn = mysqli_connect("localhost", "root", "", "db_blog");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM tbl_story";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entries</title>
    <style>
        body {
            background-color: #001f3f;
            color: #ffffff;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h2 {
            color: #17a2b8;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            background-color: transparent;
            padding: 20px;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #17a2b8;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
            background-color: transparent;
            color: #000;
            border: 1px solid #ff8c00;
            border-radius: 4px;
        }

        input[type="submit"],
        .edit-btn,
        .delete-btn {
            background-color: #ff8c00;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .success,
        .error {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .entry {
            margin: 20px 0;
            padding: 10px;
            background-color: #333;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<h2>Entries</h2>

<?php if ($successMessage): ?>
    <div class="success">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<?php if ($errorMessage): ?>
    <div class="error">
        <?php echo $errorMessage; ?>
    </div>
<?php endif; ?>

<form action="index.php" method="post">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br>
    <label for="email">Email:</label>
    <input type="text" name="email" required><br>
    <label for="topic">Topic:</label>
    <textarea name="topic" required></textarea><br>
    <label for="blog">Blog:</label>
    <textarea name="blog" required></textarea><br>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='entry'>";
        echo "<p>Name: " . $row['name'] . "</p>";
        echo "<p>Email: " . $row['email'] . "</p>";
        echo "<p>Topic: " . $row['topic'] . "</p>";
        echo "<p>Blog: " . $row['blog'] . "</p>";

        if (isset($row['student_id'])) {
            echo "<a href='edit.php?id=" . $row['student_id'] . "' class='edit-btn'>Edit</a>";
            echo "<a href='delete.php?delete_id=" . $row['student_id'] . "' class='delete-btn'>Delete</a>";
        }

        echo "</div>";
    }
} else {
    echo "<p>No entries found.</p>";
}

mysqli_close($conn);
?>

</body>
</html>
