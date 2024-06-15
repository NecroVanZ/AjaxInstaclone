<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$currentUserId = $_SESSION['USER']['user_id']; // Assuming the logged-in user's ID is stored in the session
$targetUserId = $_POST['userId'];

// Check if the current user is following the target user
$stmt = $connection->prepare('SELECT 1 FROM follow WHERE follower_id = :currentUserId AND followed_id = :targetUserId');
$stmt->execute(['currentUserId' => $currentUserId, 'targetUserId' => $targetUserId]);

if ($stmt->fetch()) {
    echo json_encode(true); // User is following
} else {
    echo json_encode(false); // User is not following
}
?>
