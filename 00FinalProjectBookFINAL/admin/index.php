<?php 
    require_once('../util/main.php');
    require_once('../util/secure_conn.php');
    require_once('../util/valid_admin.php');
    include 'view/header.php';
    include 'view/sidebar_admin.php';
?>

<main>
    <h1>Admin Menu</h1>
    
    <h2><a href="task">Task Manager</a></h2><br>
    <h2><a href="category">Category Manager</a></h2><br>
    <h2><a href="assignments">Assignment Manager</a></h2><br>
    <h2><a href="account">Administrator Account Manager</a></h2><br>
</main>

<?php include 'view/footer.php'; ?>
