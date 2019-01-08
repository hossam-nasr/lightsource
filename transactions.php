<?php

    // configuration
    require(__DIR__ . "/includes/config.php");
    
    $rows = query("SELECT * FROM `history` WHERE userid = ? ORDER BY id DESC LIMIT 5000", $_SESSION["id"]);
    
    $transactions = [];
    
    foreach ($rows as $row)
    {
    	$source = query("SELECT * FROM `sources` WHERE id = ?", $row["sourceid"])[0];
		$transaction = [];
    		$transaction["id"] = $row["id"];
    		$transaction["type"] = ($row["permanent"]) ? "Light Source" : "Auto Source"; 
    		$transaction["sourceid"] = $row["sourceid"];
    		$transaction["title"] = $source["title"];
    		$transaction["glyphicon"] = $source["glyphicon"];
    		$transaction["price"] = ($row["permanent"]) ? $source["price"] : $source["auto"];
    		
    		$transactions[] = $transaction;
    }
    
    render("transactions_form.php", ["title" => "Transactions", "transactions" => $transactions]);
?>
