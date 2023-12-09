<?php
if (isset($_POST['submit'])) {
    $newEntry = [
        'name' => $_POST['name'],
        'address' => $_POST['address'],
        'story' => $_POST['story'],
    ];

    $data = file_get_contents('data.txt');
    $entries = unserialize($data);

    if (isset($_POST['old_name'])) {
        $oldName = $_POST['old_name'];
        $entries = array_map(function ($entry) use ($newEntry, $oldName) {
            return ($entry['name'] == $oldName) ? $newEntry : $entry;
        }, $entries);
    } else {
        $entries[] = $newEntry;
    }

    $data = serialize($entries);
    file_put_contents('data.txt', $data);

    header("Location: index.php");
    exit();
} else {
    echo "<p>Invalid request.</p>";
}
?>
