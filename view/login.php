<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Motors Login </title>
    <link rel="stylesheet" href="/phpmotors/css/style.css">
    <link rel="stylesheet" href="/phpmotors/css/large.css">
</head>

<body>
    <div id="content">
        <header>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/header.php'; ?>
        </header>
        <nav id="nav">
            <?php echo $navigationHTML; ?>
            <!-- <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/navigation.php'; ?> -->
        </nav>
        <main>
            <h1 id="title">Sign in</h1>
            <?php if (isset($message)) {
                echo $message;
            } ?>
            <form action="/phpmotors/accounts/" method="post" class="form">
                <label for="clientEmail">Email</label>
                <input name="clientEmail" id="clientEmail" type="email" <?php if (isset($clientEmail)) {
                                                                            echo "value='$clientEmail'";
                                                                        } ?> required>

                <label for="clientPassword">Password</label>
                <input name="clientPassword" id="clientPassword" type="password" pattern="(?=^.{8,}$)(?=.*\d)(?=.*\W+)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required>

                <input type="hidden" name="action" value="login">

                <button name="submitBtn" id="submitBtn" type="submit">Sign-in!</button>
            </form>
            <a href="index.php?action=registration" id="signUp">Not a member yet? <b>Sign-up!</b></a>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>