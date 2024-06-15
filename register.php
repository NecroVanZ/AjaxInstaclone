<?php
session_start();
include("db/dbconnect.php");
//Resident Signup
if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$username = ($_POST['username']);
$stmt = $connection->prepare("SELECT * FROM users WHERE username = ?");
$stmt->execute([$username]);

if ($stmt->rowCount() > 0) {
    echo ('<script>alert(" Username already exist!");window.location = "registration.php";</script>');
}

// if user password and email is not empty
else { 
    
        $name = ($_POST['name']);
        $password = $_POST['password'];
        $username = ($_POST['username']);
        $bio = ($_POST['bio']);
        $user_id = ($_POST['username']);

        $profile = $_FILES['profile'];
        $fileName = $_FILES['profile']['username'];
        $fileTmpName = $_FILES['profile']['tmp_name'];
        $fileSize = $_FILES['profile']['size'];
        $fileError = $_FILES['profile']['error'];
        $fileType = $_FILES['profile']['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        
        $allowed = array('jpg', 'jpeg', 'png');

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
               
                    $fileNameNew = uniqid($name, true) . "." . $fileActualExt;
                    $fileDestination = 'img/' . $fileNameNew;
                    move_uploaded_file($fileTmpName, $fileDestination);

                    $query = "INSERT INTO users (username, password, name, bio, user_id, profile) 
                        VALUES (:username, :password, :name, :bio, :user_id, :profile)";
                    $query_run = $connection->prepare($query);

                    
                    
                    $data = [
                        ':username' => $username,
                        ':password' => $password,
                        ':name' => $name,
                        ':bio' => $bio,
                        ':user_id' => $user_id,
                        ':profile' => $fileNameNew,
                    ];

                    $query_exec = $query_run->execute($data);
                    if ($query_exec) {
                        header('Location: login.php');
                        exit(0);
                    } else {
                        $_SESSION['message'] = "There's something wrong! Please provide correct details.";
                        header('Location: registration.php?message=There\'s something wrong! Please provide correct details.');
                        exit(0);
                    }
              
            } else {
                $_SESSION['message'] = "An error uploading your file!";
                header('Location: registration.php?message=An error uploading your file!');
                exit;
            }
        } else {
            $_SESSION['message'] = "Cannot upload type file!";
            header('Location: registration.php?message=Cannot upload type file!');
    }
            exit;
        }
    }

