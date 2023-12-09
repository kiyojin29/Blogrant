<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Entry</title>
    <style>
        .success, .error {
            margin-top: 10px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }
    </style>
</head>
<body>

<h2>Add Entry</h2>

<?php
$conn = mysqli_connect("localhost", "root", "", "db_blog");
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize user input
function sanitizeInput($input)
{
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($input));
}

// Variables to store success message and error message
$successMessage = "";
$errorMessage = "";

// Check if the form is submitted
if (isset($_POST['submit'])) {
    $name = sanitizeInput($_POST['name']);
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $topic = isset($_POST['topic']) ? sanitizeInput($_POST['topic']) : '';
    $blog = isset($_POST['blog']) ? sanitizeInput($_POST['blog']) : '';

    // Insert the data into the database
    $insertQuery = "INSERT INTO tbl_story (name, email, topic, blog) VALUES ('$name', '$email', '$topic', '$blog')";
    $insertResult = mysqli_query($conn, $insertQuery);

    // Check if the query was successful
    if ($insertResult) {
        // Success message
        $successMessage = "Entry added successfully.";
    } else {
        // Error message
        $errorMessage = "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>

<!-- Display success message in a div with class 'success' -->
<?php if ($successMessage): ?>
    <div class="success">
        <?php echo $successMessage; ?>
    </div>
<?php endif; ?>

<!-- Display error message in a div with class 'error' -->
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
</body>
</html>
