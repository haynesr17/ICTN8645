<?php
require_once '../util/main.php';
require_once 'model/cart.php';
require_once 'model/task_db.php';

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {        
        $action = 'view';
    }
}

switch ($action) {
    case 'view':
        $cart = cart_get_assignment($_SESSION['user']['userID']);
        include './cart_view.php';
        break;
    
    case 'confirm_delete':
        // Get assignment data
        $assignment_id = filter_input(INPUT_POST, 'assignmentID');
        $assignment = get_assignment($assignment_id);
        $assignmentName = ($assignment['taskName']);
        
        // Get user data
        $user = get_user($assignment['userID']);
        $user_name = $user['firstName'] . ' ' . $user['lastName'];
        $email = $user['emailAddress'];

        include 'confirm_delete.php';
        break;
    
    case 'add':
        $taskID = filter_input(INPUT_GET, 'taskID', FILTER_VALIDATE_INT);
        $taskName = filter_input(INPUT_GET, 'taskName');
        $numRequired = filter_input(INPUT_GET, 'numRequired', FILTER_VALIDATE_INT);

        add_assignment($taskID, $taskName, $numRequired);
        $cart = cart_get_assignment($_SESSION['user']['userID']);
        redirect('.');
        break;
    case 'delete':
        $assignment_id = filter_input(INPUT_POST, 'assignmentID');


        delete_user_assignment($assignment_id);

        $cart = cart_get_assignment($_SESSION['user']['userID']);
        redirect('.');
        break;
    default:
        display_error("Unknown cart action: " . $action);
        break;
}


?>