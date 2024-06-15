<?php
session_start();
require 'db/dbconnect.php'; // Include your database connection

header('Content-Type: application/json'); // Set the content type to JSON

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['postId']) || !isset($_SESSION['USER']['user_id'])) {
        echo json_encode(['success' => false, 'error' => 'Missing required parameters']);
        exit;
    }

    $postId = $_POST['postId'];
    $followerId = $_SESSION['USER']['user_id'];

    // Check if the follow relationship already exists
    $stmt = $connection->prepare('SELECT COUNT(*) FROM likes WHERE post_id = ?');
    $stmt->execute([$postId]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert follow relationship into the database if it doesn't exist
        $stmt = $connection->prepare('INSERT INTO likes (post_id, user_id) VALUES (?, ?)');
        if ($stmt->execute([$postId, $followerId])) {
            echo json_encode(['success' => true, 'message' => 'Liked Post.']);
        } else {
            $errorInfo = $stmt->errorInfo();
            echo json_encode(['success' => false, 'error' => 'Database error while inserting: ' . $errorInfo[2]]);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Already liked this post.']);
    }
};

