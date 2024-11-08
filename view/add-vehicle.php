<?php checkClientAccess(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
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
            <h1 id="title">Add Vehicle</h1>
            <h2>[!] Note all Fields are required</h2>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <form action="/phpmotors/vehicles/" method="post" class="form">
                <label for="classificationId">Classification</label>
                <?php
                echo $dropDownMenu;
                ?>
                <label for="invMake">Make</label>
                <input type="text" name="invMake" id="invMake" <?php if (isset($invMake)) {
                                                                    echo "value ='$invMake'";
                                                                } ?> required>

                <label for="invModel">Model</label>
                <input type="text" name="invModel" id="invModel" <?php if (isset($invModel)) {
                                                                        echo "value ='$invModel'";
                                                                    } ?> required>
                <label for="invDescription">Description</label>
                <textarea name="invDescription" id="invDescription" required cols="30" rows="10"><?php if (isset($invDescription)) {
                                                                                                        echo $invDescription;
                                                                                                    } ?></textarea>

                <label for="invImage">Image Path</label>
                <input type="text" name="invImage" id="invImage" <?php if (isset($invImage)) {
                                                                        echo "value ='$invImage'";
                                                                    } ?> required>

                <label for="invThumbnail">Thumbnail Path</label>
                <input type="text" name="invThumbnail" id="invThumbnail" <?php if (isset($invThumbnail)) {
                                                                                echo "value ='$invThumbnail'";
                                                                            } ?> required>

                <label for="invPrice">Price</label>
                <input type="number" name="invPrice" id="invPrice" <?php if (isset($invPrice)) {
                                                                        echo "value ='$invPrice'";
                                                                    } ?> required>

                <label for="invStock"># In stock</label>
                <input type="number" name="invStock" id="invStock" <?php if (isset($invStock)) {
                                                                        echo "value ='$invStock'";
                                                                    } ?> required>

                <label for="invColor">Color</label>
                <input type="text" name="invColor" id="invColor" <?php if (isset($invColor)) {
                                                                        echo "value ='$invColor'";
                                                                    } ?> required>

                <button id="submitBtn" type="submit">Add Classification</button>
                <input type="hidden" name="action" value="vehicle-registered">
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>