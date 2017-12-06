<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<?php if (!isset($task_order_count)) { $task_order_count = 0; } ?>
<main>
    <h1>Task Manager - View Task</h1>
    
    <!-- display task -->
    <?php include '../../view/task.php'; ?>

    <!-- display buttons -->
    <br>
    <div id="edit_and_delete_buttons">
        <form action="." method="post" id="edit_button_form" >
            <input type="hidden" name="action" value="show_add_edit_form">
            <input type="hidden" name="task_id"
                   value="<?php echo $task['taskID']; ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $task['categoryID']; ?>">
            <input type="submit" value="Edit Task">
        </form>
        <?php if ($task_order_count == 0) : ?>
        <form action="." method="post" id="delete_button_form" >
            <input type="hidden" name="action" value="delete_task">
            <input type="hidden" name="task_id"
                   value="<?php echo $task['taskID']; ?>">
            <input type="hidden" name="category_id"
                   value="<?php echo $task['categoryID']; ?>">
            <input type="submit" value="Delete Task">
        </form>
        <?php endif; ?>
    </div>
    
</main>
<?php include '../../view/footer.php'; ?>