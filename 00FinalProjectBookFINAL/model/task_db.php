<?php
function get_tasks_by_category($category_id) {
    global $db;
    $query = '
        SELECT *
        FROM tasks t
           INNER JOIN categories c
           ON t.categoryID = c.categoryID
        WHERE t.categoryID = :category_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_task($task_id) {
    global $db;
    $query = '
        SELECT *
        FROM tasks t
           INNER JOIN categories c
           ON t.categoryID = c.categoryID
       WHERE taskID = :task_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function get_task_order_count($task_id) {
    global $db;
    $query = '
        SELECT COUNT(*) AS orderCount
        FROM assignments
        WHERE taskID = :task_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $task = $statement->fetch();
        $order_count = $task['orderCount'];
        $statement->closeCursor();
        return $order_count;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_task($category_id, $name, $location,
        $num, $time) {
    global $db;
    $query = 'INSERT INTO tasks
                 (categoryID, taskName, location, numRequired,
                  time)
              VALUES
                 (:category_id, :name, :location, :num, :time)';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':location', $location);
        $statement->bindValue(':num', $num);
        $statement->bindValue(':time', $time);
        $statement->execute();
        $statement->closeCursor();

        // Get the last task ID that was automatically generated
        $task_id = $db->lastInsertId();
        return $task_id;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function update_task($task_id, $category_id, $name, $location,
                        $num, $time) {
    global $db;
    $query = '
        UPDATE tasks
        SET categoryID = :category_id,
            taskName = :name,
            location = :location,
            numRequired = :num,
            time = :time
            
        WHERE taskID = :task_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->bindValue(':category_id', $category_id);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':location', $location);
        $statement->bindValue(':num', $num);
        $statement->bindValue(':time', $time);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function delete_task($task_id) {
    global $db;
    $query = 'DELETE FROM tasks WHERE taskID = :task_id';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':task_id', $task_id);
        $statement->execute();
        $statement->closeCursor();
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}
?>