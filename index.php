<?php

    // configuration
    require("includes/config.php");
    
    // load current score
    $rows = query("SELECT * FROM `users` WHERE id = ?", $_SESSION["id"]);
    
    if (count($rows) != 1)
    {
    	apologize("Unexcpected Error\n");
    }
    
    $source = query("SELECT img FROM `sources` WHERE id = ?", $rows[0]["sourceid"]);
    if (count($source) != 1)
    {
    	apologize("Unexcpected Error\n");
    }
    
    // owned sprites
    $owned = []; 
    $ownedraws = query("SELECT * FROM `history` WHERE userid = ? AND permanent = 1", $_SESSION["id"]);
    foreach ($ownedraws as $ownedraw)
    {
    	
    	$owned[] = $ownedraw["sourceid"];
    }
    
    // all sprites' properties
    $sprites = query("SELECT * FROM `sources` ORDER BY price");
    $autosprites = query("SELECT * FROM `sources` ORDER BY auto");
    
    $autocounts=[];
    foreach ($autosprites as $autosprite)
    {
    	$o = query("SELECT * FROM `history` WHERE userid = ? AND sourceid = ? AND permanent = 0", $_SESSION["id"], $autosprite["id"]);
    	$autocounts[$autosprite["id"]] = count($o);
    }
    
    // render game
    render("game.php", ["score" => $rows[0]["score"], "source" => $source[0]["img"], "rate" => $rows[0]["rate"], "sprites" => $sprites, "owned" => $owned, "autosprites" => $autosprites, "autocounts" => $autocounts]);

?>
