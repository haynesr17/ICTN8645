<?php include '../view/header.php'; ?>
<?php include '../view/sidebar.php'; ?>
<main>
    <h1>My Account</h1>
    <p><?php echo $full_name . ' (' . $email . ')'; ?></p>
    <p><?php echo $userName; ?></p>    
    <p><?php echo $superPower; ?></p>
    
    <form action="." method="post">
        <input type="hidden" name="action" value="view_account_edit">
        <input type="submit" value="Edit Account">
    </form>

    <?php if (count($assignments) > 0 ) : ?>
        <h2>Your Assignments</h2>
        
        <div class="center">
        <table>
            <tr>
                <th>Task ID</th>
                <th>Task Name</th>
                <th>Location</th>
                <th>Time</th>
                <th>Number Required</th>
            </tr>
            <?php foreach($assignments as $assignment) : ?>
            <tr>
               
                
                <td><?php echo htmlspecialchars($assignment['taskID']); ?></td>
                <td><?php echo htmlspecialchars($assignment['taskName']); ?></td>
                <td><?php echo htmlspecialchars($assignment['location']); ?></td>
                <td><?php echo htmlspecialchars($assignment['time']); ?></td>
                <td><?php echo htmlspecialchars($assignment['numRequired']); ?></td>
               
            
            </tr>
            <?php endforeach; ?> 
            </table>
        </div>
       
    <?php endif; ?>
</main>
//

<?php include '../view/footer.php'; ?>





