<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$postId = $_POST['postId'];

$query = "SELECT c.*, u.* FROM comment c 
JOIN users u ON c.post_id = :postId and u.user_id = c.user_id";
$statement = $connection->prepare($query);
$statement->bindParam("postId", $postId);
try {
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if ($result) {
        echo json_encode($result);
    } else {
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'No user found']);
    }
} catch (PDOException $e) {
    http_response_code(500); // Internal Server Error
    echo json_encode(['error' => $e->getMessage()]);
}
exit;

