<?php
// This is the main controller

// Create or access a Session
session_start();

// Get the database connection file
require_once 'library/connections.php';

// Get the PHP Motors model for use as needed
require_once 'model/main-model.php';

// Get the functions
require_once 'library/functions.php';

// Get the array of classifications
$classifications = getClassifications();

$navigationHTML = buildNavigation($classifications);


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
    case 'template':
        include 'view/template.php';
        break;
    case 'error':
        include 'view/500.php';
        break;
    default:
        include 'view/home.php';
}

// var_dump($classifications);
// exit;

// echo $navlist;
// exit;
