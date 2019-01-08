<?php

	require("includes/config.php");
	if (!isset($_GET["id"]))
	{
		apologize("You must provide an ID.");
	}
	
	$rows = query("SELECT *, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 0) AS bronze, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 1) AS silver, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 2) AS gold, 
	(SELECT COUNT(*) FROM `medals` WHERE userid = me.id AND type = 3) AS platinum,
	(SELECT COUNT(*) FROM `history` WHERE userid = me.id AND permanent = 0) AS totalauto,
	(SELECT SUM(price) FROM (SELECT *, (SELECT `sources`.price FROM `sources` WHERE `sources`.id = sourceid) AS price FROM `history` WHERE userid= ? ) AS tbl) AS totalspent
FROM `users` AS me WHERE id = ?", $_GET["id"], $_GET["id"]);
	if (count($rows) != 1)
	{
		apologize("Unexpected Error!");
	}
	
	$bronze = $rows[0]["bronze"];
	$silver = $rows[0]["silver"];
	$gold = $rows[0]["gold"];
	$platinum = $rows[0]["platinum"];
	$total = $bronze + $silver + $gold + $platinum;
	
	$datas = [];
	$pers = [];
	$suffix = [];
	
	$datas["Current score"] = formatNumber($rows[0]["score"], 3);
	$pers["Current score"] = 3;
	$suffix["Current score"] = ($rows[0]["score"] == 1) ? "photon." : " photons.";
	
	$datas["Current production"] = formatNumber($rows[0]["rate"], 2);
	$suffix["Current production"] = ($rows[0]["rate"] == 1) ? "photon/sec." : "photons/sec.";
	$pers["Current production"] = 2;
	
	$datas["Platinum medals"] = formatNumber($platinum);
	$suffix["Platinum medals"] = ($platinum == 1) ? "medal." : " medals.";
	
	$datas["Gold medals"] = formatNumber($gold);
	$suffix["Gold medals"] = ($gold == 1) ? "medal." : " medals.";
	
	$datas["Silver medals"] = formatNumber($silver);
	$suffix["Silver medals"] = ($silver == 1) ? "medal." : " medals.";
	
	$datas["Bronze medals"] = formatNumber($bronze);
	$suffix["Bronze medals"] = ($bronze == 1) ? "medal." : " medals.";
	
	$datas["Total medals"] = formatNumber($total);
	$suffix["Total medals"] = ($total == 1) ? "medal." : " medals.";
	
	$datas["Worldwide ranking"] = "N/A";
	
	$datas["Total photons spent"] = formatNumber($rows[0]["totalspent"], 3);
	$suffix["Total photons spent"] = ($rows[0]["totalspent"] == 1) ? "photon." : " photons.";
	$pers["Total photons spent"] = 3;
	
	$datas["Total automatic units"] = formatNumber($rows[0]["totalauto"]);
	$suffix["Total automatic units"] = ($rows[0]["totalauto"] == 1) ? "unit." : " units.";
	
	render("stats.php", ["title" => $rows[0]["username"] . "'s profile", "dp" => $rows[0]["dp"], "username" => $rows[0]["username"], "datas" => $datas, "pers" => $pers, "suffix" => $suffix]);

?>
