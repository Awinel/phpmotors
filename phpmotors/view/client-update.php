<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Update | PHP Motors</title>
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
            <h1 id="title"> Manage Account</h1>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <h2>Update Account</h2>
            <form action="/phpmotors/accounts/index.php" method="post" class="form">
                <label for="clientFirstname">First Name</label>
                <input type="text" name="clientFirstname" id="clientFirstname" required <?php if (isset($clientFirstname)) {
                                                                                            echo "value='$clientFirstname'";
                                                                                        } elseif (isset($clientInfo['clientFirstname'])) {
                                                                                            echo "value='$clientInfo[clientFirstname]'";
                                                                                        } ?>>

                <label for="clientLastname">Last Name</label>
                <input type="text" name="clientLastname" id="clientLastname" required <?php if (isset($clientLastname)) {
                                                                                            echo "value='$clientLastname'";
                                                                                        } elseif (isset($clientInfo['clientLastname'])) {
                                                                                            echo "value='$clientInfo[clientLastname]'";
                                                                                        } ?>>

                <label for="clientEmail">Email</label>
                <input type="email" name="clientEmail" id="clientEmail" required <?php if (isset($clientEmail)) {
                                                                                        echo "value='$clientEmail'";
                                                                                    } elseif (isset($clientInfo['clientEmail'])) {
                                                                                        echo "value='$clientInfo[clientEmail]'";
                                                                                    } ?>>
                <input type="hidden" name="action" value="updateAccount">
                <input type="hidden" name="clientId" <?php if (isset($clientId)) {
                                                            echo "value='$clientId'";
                                                        } elseif (isset($clientInfo['clientId'])) {
                                                            echo "value='$clientInfo[clientId]'";
                                                        } ?>>
                <button id="submitBtn" type="submit">Update account</button>

            </form>
            <h2>Update Password</h2>
            <form action="/phpmotors/accounts/index.php" method="post" class="form">
                <label for="clientPassword">New Password</label>
                <span>Remember that this will be the new password</span>
                <span>Passwords must be at least 8 characters and contain at least 1 number, 1 capital letter and 1 special character</span>
                <input name="clientPassword" id="clientPassword" type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>
                <input type="hidden" name="action" value="updatePassword">
                <input type="hidden" name="clientId" value="<?php if (isset($clientInfo['clientId'])) {
                                                                echo $clientInfo['clientId'];
                                                            } elseif (isset($clientInfo)) {
                                                                echo $clientInfo;
                                                            } ?>
">
                <button id="submitBtn" type="submit">Update Password</button>
            </form>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>