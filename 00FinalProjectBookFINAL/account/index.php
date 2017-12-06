<?php
require_once('../util/main.php');
require_once('util/secure_conn.php');

require_once('model/user_db.php');

require_once('model/task_db.php');

require_once('model/fields.php');
require_once('model/validate.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {        
        $action = 'view_login';
        if (isset($_SESSION['user'])) {
            $action = 'view_account';
        }
    }
}

// Set up all possible fields to validate
$validate = new Validate();
$fields = $validate->getFields();

// for the Registration page and other pages
$fields->addField('email');
$fields->addField('password_1');
$fields->addField('password_2');
$fields->addField('first_name');
$fields->addField('last_name');
$fields->addField('superPower');
$fields->addField('userName');

// for the Login page
$fields->addField('password');


switch ($action) {
    case 'view_register':
        // Clear user data
        $email = '';
        $first_name = '';
        $last_name = '';
        $superPower = '';
        $userName = '';
  
        include 'account_register.php';
        break;
    case 'register':
        // Store user data in local variables
        $email = filter_input(INPUT_POST, 'email');
        $password_1 = filter_input(INPUT_POST, 'password_1');
        $password_2 = filter_input(INPUT_POST, 'password_2');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $superPower = filter_input(INPUT_POST, 'superPower');
        $userName = filter_input(INPUT_POST, 'userName');
       
        // Validate user data       
        $validate->email('email', $email);
        $validate->text('password_1', $password_1, true, 6, 30);
        $validate->text('password_2', $password_2, true, 6, 30);        
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);
        $validate->text('superPower', $superPower);
        $validate->text('userName', $userName);

        // If validation errors, redisplay Register page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_register.php';
            break;
        }

        // If passwords don't match, redisplay Register page and exit controller
        if ($password_1 !== $password_2) {
            $password_message = 'Passwords do not match.';
            include 'account/account_register.php';
            break;
        }

        // Validate the data for the user
        if (is_valid_user_email($email)) {
            display_error('The e-mail address ' . $email . ' is already in use.');
        }
        
        // Add the user data to the database
        $user_id = add_user($email, $first_name,
                                    $last_name, $password_1, $superPower, $userName);


        // Store user data in session
        $_SESSION['user'] = get_user($user_id);
        
        // Redirect to the Checkout application if necessary
        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }        
        break;
    //code for login/register section on account/index.php
    case 'view_login':
        // Clear login data
        $email = '';
        $password = '';
        $password_message = '';
        
        include 'account_login_register.php';
        break;
    case 'login':
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        
        // Validate user data
        $validate->email('email', $email);
        $validate->text('password', $password, true, 6, 30);        

        // If validation errors, redisplay Login page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_login_register.php';
            break;
        }
        
        // Check email and password in database
        if (is_valid_user_login($email, $password)) {
            $_SESSION['user'] = get_user_by_email($email);
        } else {
            $password_message = 'Login failed. Invalid email or password.';
            include 'account/account_login_register.php';
            break;
        }

        // If necessary, redirect to the Checkout app
        // Redirect to the Checkout application
        if (isset($_SESSION['checkout'])) {
            unset($_SESSION['checkout']);
            redirect('../checkout');
        } else {
            redirect('.');
        }        
        break;
    case 'view_account':
        $full_name = $_SESSION['user']['firstName'] . ' ' .
        $_SESSION['user']['lastName'];
        $email = $_SESSION['user']['emailAddress'];        
        $userName = $_SESSION['user']['userName']; 
        $superPower = $_SESSION['user']['superPower'];  
         

        $assignments = get_assignments_by_user_id($_SESSION['user']['userID']);
     /*   if (!isset($assignments)) {
            $assignments = array();
        }        */
        include 'account_view.php';
        break;
    case 'view_assignments':
        $assignment_id = $assinment['line'];
        $assignment_taskID = $assinment['taskID'];
        $assignment_taskName = $assinment['taskName'];
      
        include 'account_view_order.php';
        break;
    case 'view_account_edit':
        
        $first_name = $_SESSION['user']['firstName'];
        $last_name = $_SESSION['user']['lastName'];
        $email = $_SESSION['user']['emailAddress'];
        $superPower = $_SESSION['user']['superPower'];
        $userName = $_SESSION['user']['userName'];

        $password_message = '';        

        include 'account_edit.php';
        break;
    
    case 'update_account':
        // Get the user data
        $user_id = $_SESSION['user']['userID'];
        $userName = filter_input(INPUT_POST, 'userName');
        $first_name = filter_input(INPUT_POST, 'first_name');
        $last_name = filter_input(INPUT_POST, 'last_name');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $superPower = filter_input(INPUT_POST, 'superPower');
        $password_1 = filter_input(INPUT_POST, 'password_1');
        $password_2 = filter_input(INPUT_POST, 'password_2');
        $password_message = '';

        // Get the old data for the user
        $old_user = get_user($user_id);

        // Validate user data
        $validate->text('userName', $userName);
        $validate->text('password_1', $password_1, false, 6, 30);
        $validate->text('password_2', $password_2, false, 6, 30);        
        $validate->text('first_name', $first_name);
        $validate->text('last_name', $last_name);       
        $validate->email('email', $email);
        $validate->text('superPower', $superPower);   
                 
        // Check email change and display message if necessary
        if ($email != $old_user['emailAddress']) {
            display_error('You can\'t change the email address for an account.');
        }

        // If validation errors, redisplay Login page and exit controller
        if ($fields->hasErrors()) {
            include 'account/account_edit.php';
            break;
        }
        
        // Only validate the passwords if they are NOT empty
        if (!empty($password_1) && !empty($password_2)) {            
            if ($password_1 !== $password_2) {
                $password_message = 'Passwords do not match.';
                include 'account/account_edit.php';
                break;
            }
        }

        // Update the user data
        update_user($user_id, $userName, $first_name, $last_name, $email,
            $superPower, $password_1, $password_2);

        // Set the new user data in the session
        $_SESSION['user'] = get_user($user_id);

        redirect('.');
        break;
    
    case 'logout':
        unset($_SESSION['user']);
        redirect('..');
        break;
    default:
        display_error("Unknown account action: " . $action);
        break;
}
?>