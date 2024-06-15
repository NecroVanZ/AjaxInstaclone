<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_POST['user_id'];

$query = "SELECT p.*, u.* FROM posts p 
        JOIN users u ON p.user_id = u.user_id
        WHERE p.user_id = :userId
        ORDER BY p.post_id DESC;";
try {
    $statement = $connection->prepare($query);
    $statement->bindParam("userId", $userId);
    $statement->execute();
    $results = $statement->fetchAll(PDO::FETCH_ASSOC);

    $posts = [];
    foreach ($results as $row) {
        if (!isset($posts[$row['post_id']])) {
            $posts[$row['post_id']] = [
                'post_id' => $row['post_id'],
                'username' => $row['username'],
                'user_id' => $row['user_id'],
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

