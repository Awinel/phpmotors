<?php checkClientAccess();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($invInfo['invMake'])) {
                echo "Delete $invInfo[invMake] $invInfo[invModel]";
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
            <h1 id="title"> <?php if (isset($invInfo['invMake'])) {
                                echo "Delete $invInfo[invMake] $invInfo[invModel]";
                            } ?></h1>
            <h2> [!] Confirm Vehicle Deletion. The delete is permanent.</h2>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <form action="/phpmotors/vehicles/index.php" method="post" class="form">
                <label for="invMake">Vehicle Make</label>
                <input type="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                    echo "value ='$invMake'";
                                                                } elseif (isset($invInfo['invMake'])) {
                                                                    echo "value='$invInfo[invMake]'";
                                                                } ?> readonly>

                <label for="invModel">Vehicle Model</label>
                <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                        echo "value ='$invModel'";
                                                                    } elseif (isset($invInfo['invModel'])) {
                                                                        echo "value='$invInfo[invModel]'";
                                                                    } ?> readonly>
                <label for="invDescription">Vehicle Description</label>
                <textarea name="invDescription" id="invDescription" cols="30" rows="10" readonly><?php if (isset($invDescription)) {
                                                                                                        echo $invDescription;
                                                                                                    } elseif (isset($invInfo['invDescription'])) {
                                                                                                        echo $invInfo['invDescription'];
                                                                                                    } ?></textarea>

                <button id="submitBtn" type="submit">Delete Vehicle</button>
                <input type="hidden" name="action" value="deleteVehicle">
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