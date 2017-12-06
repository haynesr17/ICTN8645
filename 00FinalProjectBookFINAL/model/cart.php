<?php

function add_assignment($taskID, $taskName, $numRequired)
        {
$userID = $_SESSION['user']['userID'];
$userName = $_SESSION['user']['userName']; 

    global $db;
    $query = '
        INSERT INTO assignments (userID, userName, taskID, taskName, numRequired)
        VALUES (:userID, :userName, :taskID, :taskName, :numRequired)';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':taskID', $taskID);
    $statement->bindValue(':taskName', $taskName);
    $statement->bindValue(':numRequired', $numRequired);
    $statement->execute();
    $statement->closeCursor();
}

 function get_assignment($assignment_id) {
    global $db;
    $query = 'SELECT * FROM assignments WHERE assignmentID = :assignmentID';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignmentID', $assignment_id);
    $statement->execute();
    $assignment = $statement->fetch();
    $statement->closeCursor();
    return $assignment;
 }
 
 function get_user($user_id) {
    global $db;
    $query = 'SELECT * FROM users WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function cart_get_assignment() {
    $userID = $_SESSION['user']['userID'];
    global $db;
    $query = 'SELECT * FROM assignments WHERE userID = :userID';
    $statement = $db->prepare($query);
    $statement->bindValue(':userID', $userID);
    $statement->execute();
    $user_assignments = $statement->fetchAll();
    $statement->closeCursor();
    return $user_assignments;
}

function get_tasks_by_userID() {
    $userID = $_SESSION['user']['userID'];
    global $db;
    $query = '
        SELECT *
        FROM tasks t
           INNER JOIN assignments a
           ON t.taskID = a.taskID
        WHERE a.userID = :userID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_user_assignment($assignment_id) {
    global $db;
    $query = 'DELETE  FROM assignments WHERE assignmentID = :assignmentID';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignmentID', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

?>