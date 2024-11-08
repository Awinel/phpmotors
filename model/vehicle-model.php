<?php
// Vehicle Model

function getClassificationsList()
{
    // Create a connection object from the phpmotors connection function
    $db = phpmotorsConnect();

    //The SQL statement to be used with the database
    $sql = 'SELECT classificationId FROM carclassification ORDER BY classificationName';

    // Create the prepraed statement using the phpmotors connection
    $stmt = $db->prepare($sql);

    // Runs the prepared statement
    $stmt->execute();

    // Gets the data from the database and stores it as an array in the $classification variable
    $classificationList = $stmt->fetchAll();

    // Close the interaction with the database
    $stmt->closeCursor();

    // Return the array of data back
    return $classificationList;
}

function regCarClassification($classificationName)
{
    // Creation of the connection object using the phpmotors connection function
    $db = phpmotorsConnect();
    // The sql statement
    $sql = 'INSERT INTO carclassification (classificationName)
    VALUES (:classificationName)';
    // Create the prepared statement using the phpmotors connection
    $stmt = $db->prepare($sql);
    // Replacement of the placeholders in the SQL statement
    // with the actual values in the variables and thells the
    // database the type of data it is
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    // Insert the data
    $stmt->execute();
    // Ask how many rows changed as a aresult of our insert
    $rowschanged = $stmt->rowCount();
    // Close the data base interaction
    $stmt->closeCursor();
    // Return the indication of success (row changed)
    return $rowschanged;
}

function regVehicle($invMake, $invModel, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, $invColor, $classificationId)
{
    // Create the connection object using the phpmotors connection function
    $db = phpmotorsConnect();

    // Generate a UUID
    $invId = generateUUID();

    // The SQL statement (insert invId directly)
    $sql = 'INSERT INTO inventory (invId, invMake, invModel, invDescription, invImage, invThumbnail, invPrice, invStock, invColor, classificationId)
            VALUES (:invId, :invMake, :invModel, :invDescription, :invImage, :invThumbnail, :invPrice, :invStock, :invColor, :classificationId)';

    // Create the prepared statement
    $stmt = $db->prepare($sql);

    // Bind the parameters
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_STR);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);

    // Execute the insert
    $stmt->execute();

    // Close the database interaction
    $stmt->closeCursor();

    // Return the newly created invId
    return $invId; // Return the UUID used
}

function generateUUID()
{
    return sprintf(
        '%s-%s-%s-%s-%s',
        bin2hex(random_bytes(4)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(2)),
        bin2hex(random_bytes(6))
    );
}




// Update a vehicle
function updateVehicle(
    $invMake,
    $invModel,
    $invDescription,
    $invImage,
    $invThumbnail,
    $invPrice,
    $invStock,
    $invColor,
    $classificationId,
    $invId
) {
    $db = phpmotorsConnect();
    $sql = 'UPDATE inventory SET invMake = :invMake, invModel = :invModel, invDescription = :invDescription, invImage = :invImage, invThumbnail = :invThumbnail, invPrice = :invPrice, invStock = :invStock, invColor = :invColor, classificationId = :classificationId WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->bindValue(':invMake', $invMake, PDO::PARAM_STR);
    $stmt->bindValue(':invModel', $invModel, PDO::PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO::PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO::PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO::PARAM_INT);
    $stmt->bindValue(':invStock', $invStock, PDO::PARAM_INT);
    $stmt->bindValue(':invColor', $invColor, PDO::PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Delete a vehicle
function deleteVehicle($invId)
{
    $db = phpmotorsConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Get vehicles by classificationId 
function getInventoryByClassification($classificationId)
{
    $db = phpmotorsConnect();
    $sql = ' SELECT * FROM inventory WHERE classificationId = :classificationId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationId', $classificationId, PDO::PARAM_INT);
    $stmt->execute();
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $inventory;
}

// Get vehicle information by invId
function getInvItemInfo($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $invInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}

// Get the list of vehicles based on the calssification
function getVehiclesByClassification($classificationName)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT i.*, img.imgPath AS imgPath 
            FROM inventory i
            JOIN carclassification cc ON i.classificationId = cc.classificationId
            LEFT JOIN images img ON i.invId = img.invId AND img.imgPath LIKE "%-tn%" 
            WHERE cc.classificationName = :classificationName';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':classificationName', $classificationName, PDO::PARAM_STR);
    $stmt->execute();
    $vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();

    return $vehicles;
}
// Get vehicle information by id
function getVehicleById($invId)
{
    $db = phpmotorsConnect();
    $sql = 'SELECT i.*, img.imgPath AS largeImage 
            FROM inventory i
            JOIN images img ON i.invId = img.invId AND img.imgPath NOT LIKE "%-tn%" 
            WHERE i.invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_STR);
    $stmt->execute();
    $vehicleDetails = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $vehicleDetails;
}

//  Get information for all vehicles
function getVehicles()
{
    $db = phpmotorsConnect();
    $sql = 'SELECT invId, invMake, invModel FROM inventory';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $invInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $invInfo;
}
