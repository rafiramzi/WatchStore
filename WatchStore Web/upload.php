<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];
    move_uploaded_file($file['tmp_name'], "uploads/" . $file['name']);
    echo "Uploaded!";
}
?>

<form method="POST" enctype="multipart/form-data">
    <input type="file" name="file" />
    <button type="submit">Upload</button>
</form>
