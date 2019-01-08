<!DOCTYPE html>

<html lang="en">

    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap library !-->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <!-- app's own css !-->
        <link href="/css/styles.css" rel="stylesheet"/>
        <!-- Animate.css library http://daneden.github.io/animate.css/ !-->        
        <link href="/css/animate.css" rel="stylesheet"/>

		<!-- Jquery !-->
        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <!-- Noty jquery notification plugin http://ned.im/noty/#/about !-->
        <script src="/js/noty/packaged/jquery.noty.packaged.min.js"></script>
        <!-- Underscore.string library http://epeli.github.io/underscore.string !-->
        <script src="/js/underscore.string.min.js"></script>
        <!-- app's own global javascript functions !-->
        <script src="/js/scripts.js"></script>
        <script src="/js/noselect.js"></script>

		<?php if (isset($title)): ?>
            <title>Light Source: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Light Source</title>
        <?php endif ?>
    </head>

    <body>

        <div class="container">

            <div class="row">
		        <div class="col-md-12 text-center" id="top">
		           <a href="/"><img class="img-responsive center-block" alt="Light Source" src="/img/translogo.png"/></a>
		        </div>
            </div>

            <div id="middle">
            <?php if (isset($_SESSION["id"])): ?>
                <div>
                    <ul class="links">
                    	<li class="link"><a href="/">Game</a></li>
                        <li class="link"><a href="/profile.php?id=<?= $_SESSION['id'] ?>">Profile</a></li>
                        <li class="link"><a href="/leaderboards.php">Leaderboards</a></li>
                        <li class="link"><a href="/transactions.php">Transactions</a></li>
                        <li class="link"><a href="/logout.php">Log Out</a></li>
                    </ul>
                </div>
            <?php endif ?>
