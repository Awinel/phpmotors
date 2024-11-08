<?php


// This variable is that store the type of content being request
$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
}

// This switch statement examinates the $action variable to see what its value is
switch ($action) {
    case 'template';
        include 'view/template.php';
        break;
    case 'error':
        include 'view/500.php';
        break;
    default:
        include 'view/home.php';
}
