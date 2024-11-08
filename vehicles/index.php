<?php
// This is the vehicle controller

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';

// Get the PHP Motors model for use as needed
require_once '../model/main-model.php';

// Get the vehicle models
require_once '../model/vehicle-model.php';

// Get the functions
require_once '../library/functions.php';

require_once '../model/uploads-model.php';

// Get the array of vehicle classificationId
$classificationList = getClassificationsList();

// Get the array of classifications
$classifications = getClassifications();


$navigationHTML = buildNavigation($classifications);


$dropDownMenu = buildClassificationList($classifications);




// Navigation
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
    case 'deleteVehicle':
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $deleteResult = deleteVehicle($invId);
        if ($deleteResult) {
            $message = "<p id='sM'>Congratulations the, $invMake $invModel was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p id='rM'>Error: $invMake $invModel was not
        deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        }
        break;
    case 'del':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invInfo = getInvItemInfo($invId);
        // var_dump($invId);
        // var_dump($invInfo);

        if (count($invInfo) < 1) {
            $message = 'Sorry, no vehicle information could be found.';
        }
        include '../view/vehicle-delete.php';
        exit;
        break;
    case 'updateVehicle':
        $classificationId = filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        $invMake = filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invModel = filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT);
        $invColor = filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (empty($classificationId) || empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor)) {
            $message = '<p id="rM">Please complete all information for the updated item! Double check the classification of the item.</p>';
            include '../view/vehicle-update.php';
            exit;
        }
        $updateResult = updateVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId, $invId);
        if ($updateResult) {
            $message = "<p id='sM'>Congratulations, the $invMake $invModel was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /phpmotors/vehicles/');
            exit;
        } else {
            $message = "<p id='rM'>Error. The vehicle was not updated.</p>";
            include '../view/vehicle-update.php';
            exit;
        }
        break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $invInfo = getInvItemInfo($invId);
        // var_dump($invId);
        // var_dump($invInfo);

        if (!is_array($invInfo) || count($invInfo) < 1) {
            $message = 'Sorry, No vehicle information could be found.';
        }

        include '../view/vehicle-update.php';
        break;

    case 'getInventoryItems':
        // Get the classificationId 
        $classificationId = filter_input(INPUT_GET, 'classificationId', FILTER_SANITIZE_NUMBER_INT);
        // Fetch the vehicles by classificationId from the DB 
        $inventoryArray = getInventoryByClassification($classificationId);
        // Convert the array to a JSON object and send it back 
        echo json_encode($inventoryArray);
        break;

    case 'classification-registered':
        $carClass = filter_input(INPUT_POST, 'classificationName');
        // Check for missing data
        if (empty($carClass)) {
            $message = '<h2 id="rM">[!] Please provide information.</h2>';
            include '../view/add-classification.php';
            exit;
        }
        $regOutcome = regCarClassification($carClass);
        if ($regOutcome === 1) {
            header('Location: /phpmotors/vehicles/index.php');
            exit;
        } else {
            $message = "<h2 id='rM'> Ups! Sorry, something went wrong. Please try again.</h2>";
            include '../view/add-classification.php';
            exit;
        }
        break;
    case 'vehicle-registered':
        // Retrieve and sanitize input values
        $invMake = trim(filter_input(INPUT_POST, 'invMake', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invModel = trim(filter_input(INPUT_POST, 'invModel', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invDescription = trim(filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invImage = trim(filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invThumbnail = trim(filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $invPrice = trim(filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION));
        $invStock = trim(filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_INT));
        $invColor = trim(filter_input(INPUT_POST, 'invColor', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $classificationId = trim(filter_input(INPUT_POST, 'classificationId', FILTER_SANITIZE_NUMBER_INT));

        // Check for missing data
        if (empty($invMake) || empty($invModel) || empty($invDescription) || empty($invImage) || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invColor) || empty($classificationId)) {
            $message = '<h2 id="rM">[!] Please provide the information that is missing.</h2>';
            include '../view/add-vehicle.php';
            exit;
        }

        // Call regVehicle with the updated parameters, including invStock
        // Note: Since invId is generated within the regVehicle function, it does not need to be passed here.
        $regOutcome1 = regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId);

        if ($regOutcome1) { // Assuming regVehicle returns the invId or a truthy value for success
            $message = "<h2 id='sM'> The $invMake $invModel was added successfully with ID: $regOutcome1.</h2>";
            include '../view/vehicle-man.php';
            exit;
        } else {
            $message = "<h2 id='rM'> Ups! Sorry, something went wrong. Please try again.</h2>";
            include '../view/add-vehicle.php';
            exit;
        }
        break;


    case 'add-classification':
        include '../view/add-classification.php';
        break;
    case 'add-vehicle':
        include '../view/add-vehicle.php';
        break;
    case 'classification':
        $classificationName = filter_input(INPUT_GET, 'classificationName', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicles = getVehiclesByClassification($classificationName);
        if (!count($vehicles)) {
            $message = "<p id='rM'>Sorry, no $classificationName vehicles could be found.</p>";
        } else {
            $vehicleDisplay = buildVehiclesDisplay($vehicles);
        }
        include '../view/classification.php';
        break;
    case 'vehicle':
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $vehicle = getVehicleById($invId);
        if (!$vehicle) {
            $message = "<p id='rM'>Sorry, the vehicle could not be found.</p>";
        } else {
            $vehicleInfoDisplay = buildVehicleInfoDisplay($vehicle);
        }
        include '../view/vehicle-detail.php';
        break;

    default:
        $classList = buildClassificationList($classifications);

        include '../view/vehicle-man.php';
}
