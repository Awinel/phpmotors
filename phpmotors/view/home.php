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

            <article id="article-1">
                <h1>Welcome to PHP Motors!</h1>
                <h2>DMC Delorean</h2>
                <h3>3 Cup holders<br>
                    Superman doors<br>
                    Fuzzy dice!
                </h3>

            </article>
            <div id="div-btn">
                <a href="#" id="btn"><img src="/phpmotors/images/site/own_today.png" alt="Own today button"></a>
            </div>
            <article id="article-2">
                <div id="reviews">
                    <h2>DMC Deloran Reviews</h2>
                    <ul>
                        <li>
                            <p>"So fast its almost like traveling in time." (4/5)</p>
                        </li>
                        <li>
                            <p>"Coolest ride on the road." (4/5)</p>
                        </li>
                        <li>
                            <p>"I'm feeling marry McFly." (5/5)</p>
                        </li>
                        <li>
                            <p>"The most futuristic ride of our day." (4.5/5)</p>
                        </li>
                        <li>
                            <p>"80's livin and I love it!" (5/5)</p>
                        </li>
                    </ul>
                </div>
                <div id="upgrades">
                    <div id="upgrade-title">
                        <h2>Delorean Upgrades</h2>
                    </div>
                    <div id="upgrade-1">
                        <picture><img src="/phpmotors/images/upgrades/flux-cap.png" alt=""></picture>
                    </div>
                    <a href="#" id="flux">Flux capacitor</a>
                    <div id="upgrade-2">
                        <picture><img src="/phpmotors/images/upgrades/flame.jpg" alt=""></picture>
                    </div>
                    <a href="#" id="flame">Flame Decals</a>
                    <div id="upgrade-3">
                        <picture><img src="/phpmotors/images/upgrades/bumper_sticker.jpg" alt=""></picture>
                    </div>
                    <a href="#" id="bumper">Bumper Stickers</a>
                    <div id="upgrade-4">
                        <picture><img src="/phpmotors/images/upgrades/hub-cap.jpg" alt=""></picture>
                    </div>
                    <a href="#" id="hub">Hub Caps</a>
                </div>
            </article>

        </main>
        <footer>
            <?php require_once $_SERVER['DOCUMENT_ROOT'] . '/phpmotors/snippets/footer.php'; ?>
        </footer>
    </div>
</body>

</html>