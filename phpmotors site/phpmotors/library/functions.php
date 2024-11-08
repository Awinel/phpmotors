<?php
function checkEmail($clientEmail)
{
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

function checkPassword($clientPassword)
{
    $pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]\s])(?=.*[A-Z])(?=.*[a-z])(?:.{8,})$/';
    return preg_match($pattern, $clientPassword);
}

function buildNavigation($classifications)
{
    // Navigation
    $navList = "<ul id='nav-var'>";
    $navList .= "<li> <a href ='/phpmotors/index.php' title='View the PHP Motors home page'>Home</a></li>";
    foreach ($classifications as $classification) {
        $navList .= "<li><a href='/phpmotors/index.php?action=" . urlencode($classification['classificationName']) . "' title='View our " . $classification['classificationName'] . " product line'>" . $classification['classificationName'] . "</a></li>";
    }
    $navList .= "</ul>";
    return $navList;
}

function displaySessionControls()
{
    if (isset($_SESSION['loggedin'])) {
        echo "<a id='my-account' href='/phpmotors/accounts/index.php?action=Login'>" . $_SESSION['clientData']['clientFirstname'] . "</a>";
        echo "<form action='/phpmotors/accounts/index.php' method='post'>
        <button name='submitBtn' id='submitBtn' type='submit'>Log out</button>
        
        <input type='hidden' name='action' value='logout'>
        </form>";
    } else {
        echo "<a id='my-account' href='/phpmotors/accounts/index.php?action=login-page'>My account</a>";
    }
}

function checkClientAccess()
{
    if (!isset($_SESSION['loggedin']) || $_SESSION['clientData']['clientLevel'] < 2) {
        header('Location: /phpmotors/');
        exit;
    }
}

// // Build the classifications select list 
// function buildClassificationList($classifications)
// {
//     $classificationList = '<select name="classificationId" id="classificationList">';
//     $classificationList .= "<option>Choose a Classification</option>";
//     foreach ($classifications as $classification) {
//         $classificationList .= "<option value='{$classification['classificationId']}'>{$classification['classificationName']}</option>";
//     }
//     $classificationList .= '</select>';
//     return $classificationList;
// }

// Build the classifications select list 



function buildClassificationList($classifications)
{
    $classificationList = '<select name="classificationId" id="classificationList">';
    $classificationList .= "<option>Choose a Classification</option>";
    foreach ($classifications as $classification) {
        $classificationList .= "<option value='$classification[classificationId]'";
        if (isset($classificationId)) {
            if ($classification['classificationId'] === $classificationId) {
                $classificationList .= ' selected ';
            }
        } elseif (isset($invInfo['classificationId'])) {
            if ($classification['classificationId'] === $invInfo['classificationId'])
                $classificationList .= ' selected ';
        }
        $classificationList .= ">$classification[classificationName]</option>";
    }
    $classificationList .= '</select>';
    return $classificationList;
}
