<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main>
    <?php
    if (isset($task_id)) {
        $heading_text = 'Edit Task';
    } else {
        $heading_text = 'Add Task';
    }
    ?>
    <h1>Task Manager</h1><br>
        <h2><?php echo $heading_text; ?></h2>
    <form action="index.php" method="post" id="add_task_form">
        <?php if (isset($task_id)) : ?>
            <input type="hidden" name="action" value="update_task">
            <input type="hidden" name="task_id"
                   value="<?php echo $task_id; ?>">
        <?php else: ?>
            <input type="hidden" name="action" value="add_task">
        <?php endif; ?>
            <input type="hidden" name="category_id"
                   value="<?php echo $task['categoryID']; ?>">

        <label>Category:</label>
        <select name="category_id">
        <?php foreach ($categories as $category) : 
            if ($category['categoryID'] == $task['categoryID']) {
                $selected = 'selected';
            } else {
                $selected = '';
            }
        ?>
            <option value="<?php echo $category['categoryID']; ?>"<?php
                      echo $selected ?>>
                <?php echo htmlspecialchars($category['categoryName']); ?>
            </option>
        <?php endforeach; ?>
        </select>
        <br>
        

        <label>Name:</label>
        <input type="text" name="name" 
               value="<?php echo htmlspecialchars($task['taskName']); ?>" 
               size="50">
        <br>

        <label>Number of Gals Required:</label>
        <input type="text" name="num" 
               value="<?php echo $task['numRequired']; ?>">
        <br>

        <label>Time:</label>
        <input type="time" name="time" 
               value="<?php echo $task['time']; ?>">
        <br>

        <label>Location:</label>
        <input type="text" name="location" value="<?php echo $task['location']; ?>">
        <br>

        <label>&nbsp;</label>
        <input type="submit" value="Submit">
        
    </form>
    
</main>
<?php include '../../view/footer.php'; ?>