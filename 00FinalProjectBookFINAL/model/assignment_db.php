<?php

function get_assignment($assignment_id) {
    global $db;
    $query = 'SELECT * FROM assignments WHERE assignmentID = :assignment_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $assignment = $statement->fetch();
    $statement->closeCursor();
    return $assignment;
 }

function get_assignment_items() {
    global $db;
    $query = 'SELECT * FROM assignments ';
    $statement = $db->prepare($query);
    $statement->execute();
    $assignment_items = $statement->fetchAll();
    $statement->closeCursor();
    return $assignment_items;
}

 function admin_get_assignment($assignment_id) {
    global $db;
    $query = 'SELECT * FROM assignments WHERE assignmentID = :assignment_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $assignment = $statement->fetch();
    $statement->closeCursor();
    return $assignment;
 }
 
function delete_assignment($assignment_id) {
    global $db;
    $query = 'DELETE FROM assignments WHERE assignmentID = :assignment_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':assignment_id', $assignment_id);
    $statement->execute();
    $statement->closeCursor();
}

?>