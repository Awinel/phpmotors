<?php checkClientAccess(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Classification</title>
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
            <h1 id="title">Classification</h1>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <form action="/phpmotors/vehicles/index.php" method="post" class="form">
                <label for="classificationName">Classification Name</label><br>
                <span>Make sure the classification name is no longer than 30 characters.</span>
                <input type="text" name="classificationName" id="classificationName" placeholder="Type here.." pattern="^.{1,30}$" required><br>

                <button id="submitBtn" type="submit">Add Classification</button>
                <input type="hidden" name="action" value="classification-registered">
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>