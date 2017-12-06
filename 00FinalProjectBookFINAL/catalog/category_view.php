<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1><?php echo htmlspecialchars($category_name); ?></h1>
    <?php if (count($tasks) == 0) : ?>
        <p class="textcenter"'>There are no tasks in this category. Check back again tomorrow!</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Task</th>
                <th>Location</th>
                <th>Number of Gals Needed</th>
                <th>Time of Task</th>
                <th></th>
            </tr>
            <tr>
        <?php foreach ($tasks as $task) : ?>
        
            <td><?php echo htmlspecialchars($task['taskName']); ?></td>
            <td><?php echo htmlspecialchars($task['location']); ?></td>
            <td><?php echo htmlspecialchars($task['numRequired']); ?></td>
            <td><?php echo htmlspecialchars($task['time']); ?></td>
            <td>
        <form action="<?php echo $app_path . 'cart' ?>" method="get" 
          id="add_to_cart_form">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="taskID"
                   value="<?php echo $task['taskID']; ?>">
            <input type="hidden" name="taskName"
                   value="<?php echo $task['taskName']; ?>">
            <input type="hidden" name="numRequired"
                   value="<?php echo $task['numRequired']; ?>">
            <input type="submit" value="Sign Me Up!!">
        </form>
            </td>
            </tr>
        <?php endforeach; ?>
        </table>
    <?php endif; ?>
</main>
<?php include '../view/footer.php'; ?>