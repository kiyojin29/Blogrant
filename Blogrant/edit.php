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
        background-color: #fff;
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

    input[type="submit"] {
        background-color: #ff8c00;
        color: #fff;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        border-radius: 5px;
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

    .edit-btn {
        margin-right: 5px;
        text-decoration: none;
        display: inline-block;
        border-radius: 3px;
    }
</style>


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit'])) {
    // Your update code remains the same
    // ...

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "db_blog");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $student_id = mysqli_real_escape_string($conn, $_GET['id']);

    $selectQuery = "SELECT * FROM tbl_story WHERE student_id = ?";
    $stmt = mysqli_prepare($conn, $selectQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $student_id);
        mysqli_stmt_execute($stmt);

        $selectResult = mysqli_stmt_get_result($stmt);

        if (!$selectResult) {
            echo "Error executing query: " . mysqli_error($conn);
            mysqli_close($conn);
            exit();
        }

        if (mysqli_num_rows($selectResult) > 0) {
            $row = mysqli_fetch_assoc($selectResult);
            ?>
            <form method="post" action="index.php" class="login-form">
                <input type="hidden" name="edit" value="<?php echo $row['student_id']; ?>">
                <input type="submit" value="Update" class="btn-custom">
                <div class="form-group">
                    <label>Name: <input type="text" name="name" value="<?php echo $row['name']; ?>" class="form-control"></label>
                </div>
                <div class="form-group">
                    <label>Email: <input type="text" name="email" value="<?php echo $row['email']; ?>" class="form-control"></label>
                </div>
                <div class="form-group">
                    <label>Topic: <input type="text" name="topic" value="<?php echo $row['topic']; ?>" class="form-control"></label>
                </div>
                <div class="form-group">
                    <label>Blog: <textarea name="blog" class="form-control"><?php echo $row['blog']; ?></textarea></label>
                </div>
            </form>
            <?php
        } else {
            echo "No data found for ID: $student_id";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($conn);
    }

    mysqli_close($conn);

} else {
    // Display entries or perform other actions
    // ...

    // Example: Displaying entries
    echo "<h2>Entries</h2>";
    $conn = mysqli_connect("localhost", "root", "", "db_blog");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $entriesQuery = "SELECT * FROM tbl_story";
    $result = mysqli_query($conn, $entriesQuery);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='entry'>";
            echo "<h3>{$row['topic']}</h3>";
            echo "<p>{$row['blog']}</p>";
            echo "</div>";
        }
    } else {
        echo "Error fetching entries: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>