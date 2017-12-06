<?php include 'view/header.php'; ?>
<?php include 'view/sidebar.php'; ?>
<main>
    <h2>Delete Assignment</h2>
    <p>Assignment Number: <?php echo $assignment_id; ?></p>
    <p>Assignment Name: <?php echo $assignmentName; ?></p>
    <p>User: <?php echo htmlspecialchars($user_name) . ' (' . 
            htmlspecialchars($email) . ')'; ?></p>
    <p>Are you sure you want to delete this assignment?</p>
    <form action="." method="post">
        <input type="hidden" name="action" value="delete">
        <input type="hidden" name="assignmentID"
               value="<?php echo $assignment_id; ?>">
        <input type="submit" value="Delete Assignment">
    </form>
    <br>
    <form action="." method="post">
        <input type="submit" value="Cancel">
    </form>
</main>
<?php include 'view/footer.php'; ?>