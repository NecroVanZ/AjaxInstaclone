<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id']; // Assuming the logged-in user's ID is stored in the session

// Fetch users and check if the current user is following them
$stmt = $connection->prepare('SELECT u.* FROM users u  
JOIN follow f ON f.followed_id = u.user_id AND f.follower_id = :userid
WHERE u.user_id != :userid;');
$stmt->execute(['userid' => $userId]);
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($result);
?>
