<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id'];

$query = "SELECT COUNT(*) FROM likes WHERE post_id = p.post_id AS total_notif
FROM follow f
JOIN posts p ON f.followed_id = p.user_id
JOIN users u ON f.followed_id = u.user_id
ORDER BY p.post_id DESC;";

try {
    $statement = $connection->prepare($query);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $posts = [];
    foreach ($results as $row) {
        if (!isset($posts[$row['post_id']])) {
            $posts[$row['post_id']] = [
                'post_id' => $row['post_id'],
                'username' => $row['username'],
                'user_id' => $row['user_id'],
                'likes' => $row['likes'],
                'caption' => $row['caption'],
                'profile' => $row['profile'],
                'image' => []
            ];
        }
        $posts[$row['post_id']]['images'][] = $row['image'];
    }

    echo json_encode(array_values($posts));
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
exit;
