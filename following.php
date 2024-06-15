<?php
include('db/dbconnect.php');

try {
    $query = "SELECT f1.followee.id, f1.user_id, u.username, u.profile
    FROM follow AS f1 RIGHT JOIN users ON users.user_id=f1.user_id;";
    $statement = $connection->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($result);
} catch (PDOException $th) {
    echo json_encode(['error' => $th->getMessage()]);
}