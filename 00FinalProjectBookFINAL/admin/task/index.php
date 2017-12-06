<?php
require_once('../../util/main.php');
require_once('util/secure_conn.php');
require_once('util/valid_admin.php');
require_once('model/task_db.php');
require_once('model/category_db.php');

$action = strtolower(filter_input(INPUT_POST, 'action'));
if ($action == NULL) {
    $action = strtolower(filter_input(INPUT_GET, 'action'));
    if ($action == NULL) {        
        $action = 'list_tasks';
    }
}

switch ($action) {
    case 'list_tasks':
        // get categories and tasks
        $category_id = filter_input(INPUT_GET, 'category_id', 
                FILTER_VALIDATE_INT);
        if (empty($category_id)) {
            $category_id = 1;
        }
        $current_category = get_category($category_id);
        $categories = get_categories();
        $tasks = get_tasks_by_category($category_id);

        // display task list
        include('task_list.php');
        break;
    case 'view_task':
        $categories = get_categories();
        $task_id = filter_input(INPUT_GET, 'task_id', 
                FILTER_VALIDATE_INT);
        $task = get_task($task_id);
        $task_order_count = get_task_order_count($task_id);
        include('task_view.php');
        break;
    case 'delete_task':
        $category_id = filter_input(INPUT_POST, 'category_id', 
                FILTER_VALIDATE_INT);
        $task_id = filter_input(INPUT_POST, 'task_id', 
                FILTER_VALIDATE_INT);
        delete_task($task_id);
        
        // Display the Task List page for the current category
        header("Location: .?category_id=$category_id");
        break;
    case 'show_add_edit_form':
        $task_id = filter_input(INPUT_GET, 'task_id', 
                FILTER_VALIDATE_INT);
        if ($task_id === null) {
            $task_id = filter_input(INPUT_POST, 'task_id', 
                    FILTER_VALIDATE_INT);
        }
        $task = get_task($task_id);
        $categories = get_categories();
        include('task_add_edit.php');
        break;
    case 'add_task':
        $category_id = filter_input(INPUT_POST, 'category_id', 
                FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $location = filter_input(INPUT_POST, 'location');
        $num = filter_input(INPUT_POST, 'num');
        $time = filter_input(INPUT_POST, 'time');

        // Validate inputs
        if (empty($name) || empty($location) ||
            empty($num) || empty($time)) {
            $error = 'Invalid task data.
                      Check all fields and try again.';
            include('../../errors/error.php');
        } else {
            $categories = get_categories();
            $task_id = add_task($category_id, $name,
                    $location, $num, $time);
            $task = get_task($task_id);
            include('task_view.php');
        }
        break;
    case 'update_task':
        $task_id = filter_input(INPUT_POST, 'task_id', 
                FILTER_VALIDATE_INT);
        $category_id = filter_input(INPUT_POST, 'category_id', 
                FILTER_VALIDATE_INT);
        $name = filter_input(INPUT_POST, 'name');
        $location = filter_input(INPUT_POST, 'location');
        $num = filter_input(INPUT_POST, 'num');
        $time = filter_input(INPUT_POST, 'time');

        // Validate inputs
        if (empty($name) || empty($location) ||
            empty($num) || empty($time)) {
            $error = 'Invalid task data.
                      Check all fields and try again.';
            include('../../errors/error.php');
        } else {
            $categories = get_categories();
            update_task($task_id, $category_id, $name, $location,
                           $num, $time);
            $task = get_task($task_id);
            include('task_view.php');
        }
        break;
    
}
?>