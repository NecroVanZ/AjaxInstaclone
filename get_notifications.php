<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id'];

try {
    // Fetch likes
    $likesQuery = "
        SELECT l.like_id, l.post_id, l.user_id, u.username, 'like' AS type
        FROM likes l
        JOIN users u ON l.user_id = u.user_id
        JOIN posts p ON l.post_id = p.post_id
        WHERE p.user_id = :userId
        ORDER BY l.like_id DESC";
    $likesStmt = $connection->prepare($likesQuery);
    $likesStmt->bindParam(':userId', $userId);
    $likesStmt->execute();
    $likes = $likesStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch follows
    $followsQuery = "
        SELECT f.id, f.follower_id, f.followed_id, u.username, 'follow' AS type
        FROM follow f
        JOIN users u ON f.follower_id = u.user_id
        WHERE f.followed_id = :userId
        ORDER BY f.id DESC";
    $followsStmt = $connection->prepare($followsQuery);
    $followsStmt->bindParam(':userId', $userId);
    $followsStmt->execute();
    $follows = $followsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch comments
    $commentsQuery = "
        SELECT c.id, c.post_id, c.user_id, c.comment, u.username, 'comment' AS type
        FROM comment c
        JOIN users u ON c.user_id = u.user_id
        JOIN posts p ON c.post_id = p.post_id
        WHERE p.user_id = :userId
        ORDER BY c.id DESC";
    $commentsStmt = $connection->prepare($commentsQuery);
    $commentsStmt->bindParam(':userId', $userId);
    $commentsStmt->execute();
    $comments = $commentsStmt->fetchAll(PDO::FETCH_ASSOC);

    // Combine all notifications
    $notifications = array_merge($likes, $follows, $comments);

    // Sort notifications by id (assuming higher id means more recent)

    echo json_encode($notifications);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
