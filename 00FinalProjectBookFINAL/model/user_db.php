<?php
function is_valid_user_email($email) {
    global $db;
    $query = '
        SELECT userID FROM users
        WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
}

function is_valid_user_login($email, $password) {
    global $db;
    $password = sha1($email . $password);
    $query = '
        SELECT * FROM users
        WHERE emailAddress = :email AND password = :password';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->execute();
    $valid = ($statement->rowCount() == 1);
    $statement->closeCursor();
    return $valid;
}

function get_user($user_id) {
    global $db;
    $query = 'SELECT * FROM users WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function get_user_by_email($email) {
    global $db;
    $query = 'SELECT * FROM users WHERE emailAddress = :email';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();
    return $user;
}

function get_assignments_by_user_id() {
    $userID = $_SESSION['user']['userID'];
    global $db;
    $query = '
        SELECT *
        FROM tasks t
           INNER JOIN assignments a
           ON t.taskID = a.taskID
        WHERE a.userID = :userID';
    try {
        $statement = $db->prepare($query);
        $statement->bindValue(':userID', $userID);
        $statement->execute();
        $result = $statement->fetchAll();
        $statement->closeCursor();
        return $result;
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        display_db_error($error_message);
    }
}

function add_user($email, $first_name, $last_name,
                      $password_1, $superPower, $userName) {
    global $db;
    $password = sha1($email . $password_1);
    $query = '
        INSERT INTO users (emailAddress, password, firstName, lastName, superPower, userName)
        VALUES (:email, :password, :first_name, :last_name, :superPower, :userName)';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':superPower', $superPower);
    $statement->bindValue(':userName', $userName);
    $statement->execute();
    $user_id = $db->lastInsertId();
    $statement->closeCursor();
    return $user_id;
}

function update_user($user_id, $userName, $first_name, $last_name, $email, 
                      $superPower, $password_1, $password_2) {
    global $db;
    $query = '
        UPDATE users
        SET userName = :userName,
            firstName = :first_name,
            lastName = :last_name,
            emailAddress = :email,            
            superPower = :superPower
        WHERE userID = :user_id';
    $statement = $db->prepare($query);
    $statement->bindValue(':user_id', $user_id);
    $statement->bindValue(':userName', $userName);
    $statement->bindValue(':first_name', $first_name);
    $statement->bindValue(':last_name', $last_name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':superPower', $superPower);
    $statement->execute();
    $statement->closeCursor();

    if (!empty($password_1) && !empty($password_2)) {
        $password = sha1($email . $password_1);
        $query = '
            UPDATE users
            SET password = :password
            WHERE userID = :user_id';
        $statement = $db->prepare($query);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':user_id', $user_id);
        $statement->execute();
        $statement->closeCursor();
    }
}

?>