<?php
/* **********************************
* Search Model
********************************** */
function getSearchResults($searchTerm)
{
    // THIS FUNCTION DOES A SEARCH BASED ON THE $search VALUE PASSED IN.
    $db = phpmotorsConnect();
    $sql = "SELECT * FROM inventory WHERE invDescription LIKE :searchTerm OR invId LIKE :searchTermParam";
    $searchTerm = '%' . $searchTerm . '%';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->bindParam(':searchTermParam', $searchTerm, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $results;
}

function paginate($search, $page, $displayLimit)
{
    $db = phpmotorsConnect();
    $offset = ($page - 1) * $displayLimit;
    $sql = "SELECT * FROM inventory WHERE invDescription LIKE :searchTerm OR invId LIKE :searchTermParam LIMIT :limit OFFSET :offset";
    $searchTerm = '%' . $search . '%';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $stmt->bindParam(':searchTermParam', $searchTerm, PDO::PARAM_STR);
    $stmt->bindParam(':limit', $displayLimit, PDO::PARAM_INT);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $results;
}
