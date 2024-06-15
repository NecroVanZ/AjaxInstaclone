<?php
session_start();
require 'db/dbconnect.php'; // Include your database connection

header('Content-Type: application/json'); // Set the content type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['userId']) || !isset($_SESSION['USER']['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
        exit;
    }

    $userId = $_POST['userId'];
    $followerId = $_SESSION['USER']['user_id']; // Assuming the logged-in user's ID is stored in the session

    // Check if the follow relationship already exists
    $stmt = $connection->prepare('SELECT COUNT(*) FROM follow WHERE follower_id = ? AND followed_id = ?');
    $stmt->execute([$followerId, $userId]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert follow relationship into the database if it doesn't exist
        $stmt = $connection->prepare('INSERT INTO follow (follower_id, followed_id) VALUES (?, ?)');
        if ($stmt->execute([$followerId, $userId])) {
            echo json_encode(['success' => true, 'message' => 'User followed successfully.']);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['success' => false, 'error' => 'Database error while inserting: ' . $errorInfo[2]]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Already following this user.']);
    }
};

