<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

$userId = $_SESSION['USER']['user_id'];
$query = "SELECT * FROM users WHERE user_id != :user_id";
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

