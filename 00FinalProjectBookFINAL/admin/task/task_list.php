<?php include '../../view/header.php'; ?>
<?php include '../../view/sidebar_admin.php'; ?>
<main>
    <h1>Task Manager</h1><p><h2>List Tasks</h2></p>
    <?php if (count($tasks) == 0) : ?>
    <h2 class="textcolor"><?php echo htmlspecialchars($current_category['categoryName']); ?></h2>
        <p class="textcenter">There are no tasks for this category. Choose a new category from the sidebar.</p>
    <?php else : ?>
        <h2 class="textcolor">
            <?php echo htmlspecialchars($current_category['categoryName']); ?>
        </h2>
            <?php foreach ($tasks as $task) : ?>
            <p>
                <a href="?action=view_task&amp;task_id=<?php
                          echo $task['taskID']; ?>">
                    <?php echo htmlspecialchars($task['taskName']); ?>
                </a>
            </p>
            <?php endforeach; ?>
    <?php endif; ?>

    <h3>Links</h3>
    <h4 class="textcenter"><a href="index.php?action=show_add_edit_form">Add Task</a></h4>

</main>
<?php include '../../view/footer.php'; ?>