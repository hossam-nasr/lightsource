<?php

	require(__DIR__ . "/includes/config.php");

    // ensure proper usage
    if ( !isset($_POST["score"]) or  !isset($_SESSION["id"]) or $_SERVER["REQUEST_METHOD"] != "POST")
    {
        http_response_code(400);
        exit;
    }

	// authenticate sender
	if ($_POST["code"] != CODE)
	{
		http_response_code(403);
		exit;
	}
	
    // escape user's input
	$score = urlencode($_POST["score"]);
    
    $response["success"] = true;
    
    // save only score
    if ($_POST["mode"] == "score")
    {		
		// save new score
		$rows = query("UPDATE `users` SET score = ? WHERE id = ?", $score, $_SESSION["id"]);
	}
	// save score and sprite
	elseif ($_POST["mode"] == "sprite")
	{
		// escape user's input
		$sprite = urlencode($_POST["sprite"]);
		$rows = query("UPDATE `users` SET score = ?, sourceid = ? WHERE id = ?", $score, $sprite, $_SESSION["id"]);		
	}
	// save score, sprite and owned sprites
	else
	{
		// escape user's input
		$sprite = urlencode($_POST["sprite"]);
		$owned  = $_POST["owned"];
		$rows = query("UPDATE `users` SET score = ?, sourceid = ? WHERE id = ?", $score, $sprite, $_SESSION["id"]);
		if ($rows === false)
		{
			$response["success"] = false;
		}
		$rows = query("INSERT INTO `history` (userid, sourceid, permanent) VALUES (?, ?, 1)", $_SESSION["id"], $owned);
	}
    
    
    if ($rows === false)
    {
    	$response["success"] = false;
    }
    
    // output repsonse as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($response, JSON_PRETTY_PRINT));

?>
