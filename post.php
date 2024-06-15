<?php
session_start();
include("db/dbconnect.php");

$userId = $_SESSION['USER']['user_id'];
$caption = $_POST['caption'];
$post_id = uniqid();

$total_files = count($_FILES['userfile']['name']);

for($i=0; $i<$total_files; $i++)  {
    $target_dir = "img/";
    $target_file = $target_dir . basename($_FILES["userfile"]["name"][$i]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if file already exists
    if (file_exists($target_file)) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, file already exists.']);
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["userfile"]["size"][$i] > 5000000) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file is too large.']);
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.']);
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Sorry, your file was not uploaded.']);
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["userfile"]["tmp_name"][$i], $target_file)) {
            echo json_encode(['status' => 'success', 'message' => 'The file '. basename( $_FILES["userfile"]["name"][$i]). ' has been uploaded.']);

            // Insert file information into the database
            $sql = "INSERT INTO posts (user_id, caption, post_id, image) VALUES (:userId, :caption, :post_id, :file_name)";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':caption', $caption);
            $stmt->bindParam(':userId', $userId);
            $stmt->bindParam(':post_id', $post_id);
            $stmt->bindParam(':file_name', $_FILES["userfile"]["name"][$i]);
            $stmt->execute();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error uploading your file.']);
        }
    }
}

