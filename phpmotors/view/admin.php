<?php
if (!isset($_SESSION["loggedin"])) {
    echo "<p id='rM'>Please log in</p>";
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors</title>
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
            <?php
            if (isset($_SESSION['loggedin'])) {
                echo '<h1 id="title">' . $_SESSION['clientData']['clientFirstname'] . " " . $_SESSION['clientData']['clientLastname'] . '</h1>';
                if (isset($message)) {
                    echo $message;
                };
                echo '<h2>You are logged in.</h2>';
                echo '<ul>';
                echo '<li>Firstname: ' . $_SESSION['clientData']['clientFirstname'] . '</li>';
                echo '<li>Lastname: ' . $_SESSION['clientData']['clientLastname'] . '</li>';
                echo '<li>Email: ' . $_SESSION['clientData']['clientEmail'] . '</li>';
                echo '</ul>';
                echo "<div class='management'><h3>Account Management</h3>
        <p>Use this link to manage the inventory.</p><br>
        <a href='/phpmotors/accounts/index.php?action=updateAccount'>Account Management</a></div>";
            }
            ?>
            <?php if ($_SESSION['clientData']['clientLevel'] > 1) {
                echo "<div class='management'><h3>Inventory Management</h3>
        <p>Use this link to manage the inventory.</p><br>
        <a href='/phpmotors/vehicles/index.php'>Vehicle Management</a> </div>";
            } else {
                echo "<h1>ʕ •ᴥ•ʔ ฅ^•ﻌ•^ฅ (ᵔᴥᵔ) (ˆ(oo)ˆ) (❍ᴥ❍ʋ)</h1>";
            } ?>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>