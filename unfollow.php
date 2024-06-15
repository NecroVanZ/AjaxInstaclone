<?php
session_start();
require 'db/dbconnect.php';  // Include your database connection


header('Content-Type: application/json'); // Set the content type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['userId']) || !isset($_SESSION['USER']['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
        exit;
    }

    $userId = $_POST['userId'];
    $followerId = $_SESSION['USER']['user_id']; // Assuming the logged-in user's ID is stored in the session

    // Check if the follow relationship exists
    $stmt = $connection->prepare('SELECT COUNT(*) FROM follow WHERE follower_id = ? AND followed_id = ?');
    $stmt->execute([$followerId, $userId]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Delete follow relationship from the database if it exists
        $stmt = $connection->prepare('DELETE FROM follow WHERE follower_id = ? AND followed_id = ?');
        if ($stmt->execute([$followerId, $userId])) {
            echo json_encode(['success' => true, 'message' => 'User unfollowed successfully.']);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['success' => false, 'error' => 'Database error while deleting: ' . $errorInfo[2]]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'You are not following this user.']);
    }
}
