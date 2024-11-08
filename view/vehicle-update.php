<?php checkClientAccess();

// Classification option list
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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                echo "Modify $invInfo[invMake] $invInfo[invModel]";
            } elseif (isset($invMake) && isset($invModel)) {
                echo "Modify $invMake $invModel";
            } ?> | PHP Motors</title>
    <link rel="stylesheet" href="/phpmotors/css/style.css">
    <link rel="stylesheet" href="/phpmotors/css/large.css">
</head>

<body>
    <div id="content">
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
        </header>
        <nav id="nav">
            <!-- <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; ?> -->
            <?php echo $navigationHTML; ?>
        </nav>
        <main>
            <h1 id="title"> <?php if (isset($invInfo['invMake']) && isset($invInfo['invModel'])) {
                                echo "Modify $invInfo[invMake] $invInfo[invModel]";
                            } elseif (isset($invMake) && isset($invModel)) {
                                echo "Modify$invMake $invModel";
                            } ?></h1>
            <h2>[!] Note all Fields are required</h2>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <form action="/phpmotors/vehicles/index.php" method="post" class="form">
                <label for="classificationList">Classification</label>
                <?php
                echo $classificationList;
                ?>
                <label for="invMake">Make</label>
                <input type="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                    echo "value ='$invMake'";
                                                                } elseif (isset($invInfo['invMake'])) {
                                                                    echo "value='$invInfo[invMake]'";
                                                                } ?> required>

                <label for="invModel">Model</label>
                <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                        echo "value ='$invModel'";
                                                                    } elseif (isset($invInfo['invModel'])) {
                                                                        echo "value='$invInfo[invModel]'";
                                                                    } ?> required>
                <label for="invDescription">Description</label>
                <textarea name="invDescription" id="invDescription" required cols="30" rows="10"><?php if (isset($invDescription)) {
                                                                                                        echo $invDescription;
                                                                                                    } elseif (isset($invInfo['invDescription'])) {
                                                                                                        echo $invInfo['invDescription'];
                                                                                                    } ?></textarea>

                <label for="invImage">Image Path</label>
                <input type="text" name="invImage" id="invImage" <?php if (isset($invImage)) {
                                                                        echo "value ='$invImage'";
                                                                    } elseif (isset($invInfo['invImage'])) {
                                                                        echo "value='$invInfo[invImage]'";
                                                                    } ?> required>

                <label for="invThumbnail">Thumbnail Path</label>
                <input type="text" name="invThumbnail" id="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                                echo "value ='$invThumbnail'";
                                                                            } elseif (isset($invInfo['invThumbnail'])) {
                                                                                echo "value='$invInfo[invThumbnail]'";
                                                                            } ?> required>

                <label for="invPrice">Price</label>
                <input type="number" name="invPrice" id="invPrice" <?php if (isset($invPrice)) {
                                                                        echo "value ='$invPrice'";
                                                                    } elseif (isset($invInfo['invPrice'])) {
                                                                        echo "value='$invInfo[invPrice]'";
                                                                    } ?> required>

                <label for="invStock"># In stock</label>
                <input type="number" name="invStock" id="invStock" <?php if (isset($invStock)) {
                                                                        echo "value ='$invStock'";
                                                                    } elseif (isset($invInfo['invStock'])) {
                                                                        echo "value='$invInfo[invStock]'";
                                                                    } ?> required>

                <label for="invColor">Color</label>
                <input type="text" name="invColor" id="invColor" <?php if (isset($invColor)) {
                                                                        echo "value ='$invColor'";
                                                                    } elseif (isset($invInfo['invColor'])) {
                                                                        echo "value='$invInfo[invColor]'";
                                                                    } ?> required>

                <button id="submitBtn" type="submit">Update Vehicle</button>
                <input type="hidden" name="action" value="updateVehicle">
                <input type="hidden" name="invId" value="<?php if (isset($invInfo['invId'])) {
                                                                echo $invInfo['invId'];
                                                            } elseif (isset($invId)) {
                                                                echo $invId;
                                                            } ?>
">
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>