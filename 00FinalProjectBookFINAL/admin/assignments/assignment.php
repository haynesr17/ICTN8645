<?php include 'view/header.php'; ?>
<?php include 'view/sidebar_admin.php'; ?>
<main>
    <h1>Assignment Information</h1>

    <table>
        <tr>
            <th>Assignment ID</th>
            <th>Task Number</th>
            <th>Task Name</th>
            <th>User Number</th>
            <th>User Name</th>
            <th></th>
            
        </tr>
        <?php
        
        foreach ($assignment_items as $item) :
            $assignmentID = $item['assignmentID'];
            $task_id = $item['taskID'];
            $task = get_task($task_id);
            $item_name = $task['taskName'];
            $userID = $item['userID'];
            $userName = $item['userName'];
        ?>
            <tr>
                <td><?php echo $item['assignmentID']; ?></td>
                <td><?php echo $item['taskID']; ?></td>
                <td><?php echo htmlspecialchars($item_name); ?></td>
                <td><?php echo $item['userID']; ?></td>
                <td><?php echo htmlspecialchars($item['userName']); ?></td>
                
                <td>        
                <form action="." method="post" >
                <input type="hidden" name="action" value="confirm_delete">
            <input type="hidden" name="assignment_id" value="<?php echo $item['assignmentID']; ?>">
            <input type="submit" value="Delete Assignment">
        </form></td>
                
            </tr>
        <?php endforeach; ?>
               
</table>
</main>
<?php include 'view/footer.php'; ?>