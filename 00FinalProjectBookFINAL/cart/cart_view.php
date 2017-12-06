<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>Your Tasks</h1>

        <table id="cart">
            <tr id="cart_header">
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Location</th>
                <th>Time</th>
                <th>Number Required</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($cart as $task_id => $item) : ?>
            <tr>
                <td><?php echo ($item['assignmentID']); ?></td>
                
                <td><?php echo ($item['userID']); ?></td>
                
                <td><?php echo htmlspecialchars($item['userName']); ?></td>
                
                <td><?php echo ($item['taskID']); ?></td>
                
                <td><?php echo htmlspecialchars($item['taskName']); ?></td>
                
                <td><?php echo ($item['numRequired']); ?></td>
                
                <td>
                <form action="." method="post" >
                <input type="hidden" name="action" value="confirm_delete">
                <input type="hidden" name="assignmentID" value="<?php echo $item['assignmentID']; ?>">
                <input type="submit" value="Remove Task"></form></td>
            </tr>
            <?php endforeach; ?>

            </table>
        
    
</main>
<?php include '../view/footer.php'; ?>