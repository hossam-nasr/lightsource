<?php

	 require(__DIR__ . "/includes/config.php");

    // ensure proper usage
    if (empty($_POST["params"]) or $_SERVER["REQUEST_METHOD"] != "POST")
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
	
	foreach (array_keys($_POST["params"], "-1") as $key)
	{
		$_POST["params"][$key] = $_SESSION["id"];
	}
	 
    $response = call_user_func_array("query", $_POST["params"]);
    
    
    if ($response === false)
    {
    	$response["success"] = false;
    }
    else
    {
    	$response["success"] = true;
    }
    
    // output repsonse as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($response, JSON_PRETTY_PRINT));

?>
