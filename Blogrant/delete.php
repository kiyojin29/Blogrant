<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $conn = mysqli_connect("localhost", "root", "", "db_blog");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $deleteQuery = "DELETE FROM tbl_story WHERE student_id = '$id'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    mysqli_close($conn);

    if ($deleteResult) {
        header("Location: index.php");
        exit();
    } else {
        die("Error deleting entry: " . mysqli_error($conn));
    }
} else {
    http_response_code(400);
    die("Invalid request");
}
?>
