<?php
// This is the accounts controler controller

// Create or access a Session
session_start();

// Get the functions library
require_once '../library/functions.php';

// Get the database connection file
require_once '../library/connections.php';

// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

// Get the accounts model
require_once '../model/accounts-model.php';

// Get the functions
require_once '../library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

$navigationHTML = buildNavigation($classifications);


// // Navigation
// $navList = "<ul id='nav-var'>";
// $navList .= "<li> <a href ='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
// foreach ($classifications as $classification) {
//     $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our $classification[classificationName] product line'>$classification[classificationName]</a></li>";
// }
// $navList .= "</ul>";

// This variable is that store the type of content being request
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

//Check for cookies
if (isset($_SESSION['loggedin'])) {
    $cookieFirstname = $_SESSION['clientData']['clientFirstname'];
}

// This switch statement examinates the $action variable to see what its value is
switch ($action) {
    case 'updateAccount':
        // Retrieve data of the logged-in client
        $clientInfo = getClientInfo($_SESSION['clientData']['clientId']);

        // Sanitize input fields
        $clientId = $_SESSION['clientData']['clientId'];
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);

        $checkEmail = checkEmail($clientEmail);
        $existingEmail = checkExistingEmail($clientEmail);

        // Check if the email is being updated
        if ($clientInfo['clientEmail'] !== $clientEmail) {
            $existingEmail = checkExistingEmail($clientEmail);

            // Check for existing email address in the table
            if ($existingEmail) {
                $message = '<p id="rM">That email address already exists. Please provide one that is not in use.</p>';
                include '../view/client-update.php';
                exit;
            }
        }

        if (empty($clientId) || empty($clientFirstname) || empty($clientLastname) || empty($clientEmail)) {
            $message = '<p id="rM">Please complete all information to update the account.</p>';
            include '../view/client-update.php';
            exit;
        }
        $updateResult = updateAccount($clientId, $clientFirstname, $clientLastname, $clientEmail);

        if ($updateResult) {
            $message = "<p id='sM'>The account information has been updated.</p>";
            $_SESSION['message'] = $message;
            include '../view/client-update.php';
            exit;
        } else {
            $message = "<p id='rM'>Sorry, the account information was not updated.</p>";
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'updatePassword':
        $clientId = $_SESSION['clientData']['clientId'];
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkPassword = checkPassword($clientPassword);

        if (empty($checkPassword)) {
            $message = "<p id='rM'> The password cannot be empty.</p>";
            include '../view/client-update.php';
            exit;
        }
        $updatePassword = updateClientPassword($clientId, $clientPassword);

        if ($updatePassword === 1) {
            $message = "<p id='sM'>The password has been updated.</p>";
            include '../view/admin.php';
            exit;
        } else {
            $message = "<p id='rM'>Sorry, an error occurred while updating the password.</p>";
            include '../view/client-update.php';
            exit;
        }
        break;
    case 'register':
        $clientFirstname = trim(filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientLastname = trim(filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

        $checkEmail = checkEmail($clientEmail);
        $checkPassword = checkPassword($clientPassword);

        $existingEmail = checkExistingEmail($clientEmail);

        // Check for existing email address in the table
        if ($existingEmail) {
            $message = '<p id="rM">That email address already exists. Do you want to login instead?</p>';
            include '../view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($checkEmail) || empty($checkPassword)) {
            $message = '<p id="rM">[!] Please provide information for all empty form fields.</p>';
            include '../view/registration.php';
            exit;
        }

        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $checkEmail, $hashedPassword);

        if ($regOutcome === 1) {
            // setcookie("firstName", $clientFirstname, strtotime("+ i year"), "/");
            $message = $_SESSION['message'] = "<p id='sM'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            include '../view/login.php';
            exit;
        } else {
            $message = "<p id='rM'> Ups! Sorry $clientFirstname, but the registration failed. Please try again.</p>";
            include '../view/registration.php';
            exit;
        }
        break;
    case 'registration':
        include '../view/registration.php';
        break;

    case 'login-page':
        include '../view/login.php';
        break;
    case 'login':
        $clientEmail = trim(filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL));
        $checkEmail = checkEmail($clientEmail);
        $clientPassword = trim(filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $checkPassword = checkPassword($clientPassword);


        if (empty($checkEmail) || empty($checkPassword)) {
            $message = "<p id='rM'> Sorry, there is an error with the information please try again.</p>";
            include '../view/login.php';
            exit;
        }

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against
        // the hashed password for the matching client
        if ($clientData !== false) {
            $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        } else {
            $message = '<p id="rM">Sorry there is not an account with that information please try to sign up.</p>';
            include '../view/login.php';
            exit;
        }
        // If the hashes don't match create an error
        // and return to the login view
        if (!$hashCheck) {
            $message = '<p id="rM">Please check your password and try again.</p>';
            include '../view/login.php';
            exit;
        }
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        // the array_pop function removes the last
        // element from an array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        // Add the coockie to be display
        $cookieFirstname = $_SESSION['clientData']['clientFirstname'];
        // Send them to the admin view
        include '../view/admin.php';
        exit;
        break;
    case 'logout':

        unset($_SESSION['loggedin']);
        unset($_SESSION['clientData']);
        session_destroy();
        header('Location: /phpmotors/index.php');
        break;
    default:
        include '../view/admin.php';
}

// var_dump($classifications);
// exit;

// echo $navlist;
// exit;