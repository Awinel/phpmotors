<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search | PHP Motors</title>
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
            <form action="/phpmotors/search" method="get" class="searchForm">
                <label for="search" class="hidden">You searched for:</label>
                <input type="text" name="search" id="search" required <?php if (isset($search)) {
                                                                            echo "value='$search'";
                                                                        } ?>>
                <input type="hidden" name="action" value="search">

                <button type="submit" id="searchBtn">Search</button>
            </form>
            <div id="results">
                <?php if (isset($message)) {
                    echo $message;
                } ?>
                <?php
                if (isset($searchDisplay)) {
                    echo $searchDisplay;
                }

                if (isset($paginationBar)) {
                    echo $paginationBar;
                }
                ?>
            </div>
        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>