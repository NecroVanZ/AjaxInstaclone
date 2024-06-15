<?php
session_start();
header('Content-Type: application/json');
include('db/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['comment']) && isset($_POST['postId']) && isset($_SESSION['USER']['user_id'])) {
        // Insert new comment
        $comment = $_POST['comment'];
        $postId = $_POST['postId'];
        $userId = $_SESSION['USER']['user_id'];
        $commentId = uniqid('comment_', true);

        $insertQuery = "INSERT INTO comment (user_id, post_id, comment, comment_id) VALUES (:userId, :postId, :comment, :comment_id)";
        $insertStmt = $connection->prepare($insertQuery);
        $insertStmt->bindParam(":userId", $userId);
        $insertStmt->bindParam(":postId", $postId);
        $insertStmt->bindParam(":comment", $comment);
        $insertStmt->bindParam(":comment_id", $commentId);

        try {
            $insertStmt->execute();
            echo json_encode(['success' => 'Comment added successfully']);
        } catch (PDOException $e) {
            http_response_code(500); // Internal Server Error
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid input']);
    }
} else {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Invalid request method']);
}
exit;
?>
