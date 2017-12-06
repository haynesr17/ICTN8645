<?php
require_once('../../util/main.php');
require_once('util/secure_conn.php');

require_once('model/user_db.php');
require_once('model/assignment_db.php');
require_once('model/task_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {        
        $action = 'view_assignment';
    }
}

switch($action) {

    case 'view_assignment':
        $assignment_items = get_assignment_items();
        include 'assignment.php';
        break;
 
    case 'confirm_delete':
        // Get assignment data
        $assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
        $assignment = get_assignment($assignment_id);
        $assignmentName = ($assignment['taskName']);
        // Get user data
        $user = get_user($assignment['userID']);
        $user_name = $user['firstName'] . ' ' . $user['lastName'];
        $email = $user['emailAddress'];

        include 'confirm_delete.php';
        break;
    case 'delete':
        $assignment_id = filter_input(INPUT_POST, 'assignment_id', FILTER_VALIDATE_INT);
        delete_assignment($assignment_id);
        redirect('.');
        break;
    default:
        display_error("Unknown assignment action: " . $action);
        break;
}
?>