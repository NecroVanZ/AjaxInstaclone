<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id'];
$postId = $_POST['postId'];
$stmt = $connection->prepare('SELECT COUNT(*) as like_count FROM likes WHERE post_id = :postId');
$stmt->execute(['postId' => $postId]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result['like_count'] == 0) {
    echo json_encode(false);
} else {
    echo json_encode(true);
}

