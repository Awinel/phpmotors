<?php
// Main PHP Motors Model

function getClassifications()
{
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();

    // The SQL statement to be used with the database to select both ID and Name
    $sql = 'SELECT classificationId, classificationName FROM carclassification ORDER BY classificationName ASC';

    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // Runs the prepared statement
    $stmt->execute();

    // Gets the data from the database and stores it as an array in the $classifications variable
    $classifications = $stmt->fetchAll();

    // Close the interaction with the database
    $stmt->closeCursor();

    // Return the array of data back
    return $classifications;
}
