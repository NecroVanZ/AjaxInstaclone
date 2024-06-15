<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id'];

try {
    // Count likes on the user's posts (distinct post IDs)
    $likesQuery = "
        SELECT COUNT(DISTINCT l.post_id) AS count
        FROM likes l
        JOIN posts p ON l.post_id = p.post_id
        WHERE p.user_id = :userId";
    $likesStmt = $connection->prepare($likesQuery);
    $likesStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $likesStmt->execute();
    $likesCount = $likesStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Count follows where the current user is followed
    $followsQuery = "
        SELECT COUNT(*) AS count
        FROM follow f
        WHERE f.followed_id = :userId";
    $followsStmt = $connection->prepare($followsQuery);
    $followsStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $followsStmt->execute();
    $followsCount = $followsStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Count comments on the user's posts (distinct post IDs)
    $commentsQuery = "
        SELECT COUNT(DISTINCT c.post_id) AS count
        FROM comment c
        JOIN posts p ON c.post_id = p.post_id
        WHERE p.user_id = :userId";
    $commentsStmt = $connection->prepare($commentsQuery);
    $commentsStmt->bindParam(':userId', $userId, PDO::PARAM_INT);
    $commentsStmt->execute();
    $commentsCount = $commentsStmt->fetch(PDO::FETCH_ASSOC)['count'];

    // Calculate total notifications
    $totalNotifications = $likesCount + $followsCount + $commentsCount;

    $response = [
        'total_notifications' => $totalNotifications,
        'likes' => $likesCount,
        'follows' => $followsCount,
        'comments' => $commentsCount
    ];

    echo json_encode($response);
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
?>
