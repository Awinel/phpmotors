<?php

/*************************
 * Search Controller
 * Final Project End Code
 ************************/

// Create or access a Session
session_start();

// Get the database connection file
require_once '../library/connections.php';
// Get the main model for use as needed
require_once '../model/main-model.php';
require_once '../model/search-model.php';
require_once '../model/vehicle-model.php';
require_once '../library/functions.php';

// Get the array of classifications from DB using model
$classifications = getClassifications();

// Build a navigation bar using the $classifications array
$navigationHTML = buildNavigation($classifications);

$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($action == null) {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}

switch ($action) {
    case 'search':

        $search = trim(filter_input(INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS)) ?: trim(filter_input(INPUT_GET, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
        $vehicleInformation = getVehicles();
        if (empty($search)) {
            $message = '<p id="rM">You must provide a search string.</p>';
            include '../view/search.php';
            exit;
        }

        $sResults = getSearchResults($search);
        $srNum = count($sResults);

        // page is always pulled from the pagination links, so no need to look at the INPUT_POST
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_NUMBER_INT);
        if (empty($page)) {
            $page = 1;
            $message = "<h1>Returned $srNum results for: $search</h1>";
        }



        $paginationBar = ''; // Define pagination bar variable
        if ($srNum < 1) {
            $searchDisplay = "<h1>Returned $srNum results for: $search</h1><br>
            <h1>Sorry, there are no results.</h1>";
        } elseif ($srNum > 10) {

            $message = "<h1>Returned $srNum results for: $search</h1>";

            //Calculate number of pages needed
            $displayLimit = 10; // ENTRIES PER PAGE
            $totalPages = ceil($srNum / $displayLimit);

            $paginatedResults = paginate($search, $page, $displayLimit);

            // This is the pagination bar (e.g. the HTML that goes under your search results)
            $paginationBar = pagination($totalPages, $page, "&search=$search");

            // Using the same function, but using the paginatedResults instead of all the results
            $searchDisplay = buildSearchResults($paginatedResults, $vehicleInformation);
        } else {
            $searchDisplay = buildSearchResults($sResults, $vehicleInformation);
        }
        include '../view/search.php';
        break;
    default:
        include '../view/search.php';
        break;
}
