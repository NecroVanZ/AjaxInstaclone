<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_POST['user_id'];

$query = "SELECT u.*, 
                 (SELECT COUNT(*) FROM follow WHERE followed_id = :user_id) AS follower_count,
                 (SELECT COUNT(*) FROM follow WHERE follower_id = :user_id) AS following_count
          FROM users u 
          WHERE u.user_id = :user_id";
$statement = $connection->prepare($query);
$statement->bindParam(':user_id', $userId);

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
?>
