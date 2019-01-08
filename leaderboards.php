<?php

    // configuration
    require(__DIR__ . "/includes/config.php");
    
    $rows = query("SELECT id, username, score, rate,
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 0) AS bronze, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 1) AS silver, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 2) AS gold, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 3) AS platinum
FROM `users` AS me ORDER BY platinum DESC, gold DESC, silver DESC, bronze DESC, score DESC LIMIT 5000");
    
    render("leaderboards_form.php", ["title" => "Leaderboards", "logs" => $rows]);
?>
