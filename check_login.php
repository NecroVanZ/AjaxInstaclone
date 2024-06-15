<?php
session_start(); // Start the session
include("db/dbconnect.php");

if (isset($_POST['login'])) {
    $username = trim($_POST['username']); // Trim whitespace
    $password = $_POST['password'];

    $user = check_credentials($connection, $username, $password);
    if ($user) {
        session_regenerate_id(true); // Regenerate session ID
        $_SESSION['USER'] = [
            'user_id' => $user['user_id'],
            'username' => $user['username'],
            'name' => $user['name'],
            'bio' => $user['bio'],
            'profile' => $user['profile'],
        ];
        $_SESSION['logged_in'] = true; // Mark the user as logged in
        header("Location: user/index.php"); // Redirect to dashboard
        exit;
    } else {
        echo "Invalid username or password";
    }
}

function check_credentials($connection, $username, $password)
{
    try {
        $stmt = $connection->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
        $stmt->execute([$username, $password]);

        if ($stmt->rowCount() === 1) {
            $row = $stmt->fetch();
            return $row;
        } else {
            return false;
        }
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage()); // Logging the error
        return false;
    }
}
