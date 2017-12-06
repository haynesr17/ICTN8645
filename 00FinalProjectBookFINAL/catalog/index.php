<?php
require_once('../util/main.php');
require_once('../model/task_db.php');
require_once('../model/category_db.php');

$category_id = filter_input(INPUT_GET, 'category_id', FILTER_VALIDATE_INT);
$task_id = filter_input(INPUT_GET, 'task_id', FILTER_VALIDATE_INT);
if ($category_id !== null) {
    $action = 'category';
} else {
    $action = '';
}

switch ($action) {
    // Display the specified category
    case 'category':
        // Get category data
        $category = get_category($category_id);
        $category_name = $category['categoryName'];
        $tasks = get_tasks_by_category($category_id);

        // Display category
        include('./category_view.php');
        break;
    
    default:
        $error = 'Unknown catalog action: ' . $action;
        include('errors/error.php');
        break;
}
?>