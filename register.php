<?php

    //configuration
    require("includes/config.php");
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }
    
    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if (empty($_POST["confirmation"]))
        {
            apologize("You must confirm your password.");
        }
        else if (empty($_POST["email"]))
        {
            apologize("You must provide an e-mail address.");
        }
        else if ($_POST["confirmation"] != $_POST["password"])
        {
            apologize("Your confirmation must match the password.");
        }
#        else if (verifyEmail($_POST["email"], "harrypotter1061999@hotmail.com") == "invalid")
#        {
#            apologize("Invalid email address");
#        }
        
        // ensure user hasn't signed up before
        $users = query("SELECT * FROM `users` WHERE email = ? OR username = ?", $_POST["email"], $_POST["username"]);
        if (count($users) != 0)
        {
        	$wrongpart = ($users[0]["email"] == $_POST["email"]) ? "email address" : "username";
            apologize("an account is already registered with that $wrongpart");
        }
        
        $rows = query("INSERT INTO `users` (username, hash, email) VALUES (?, ?, ?)", $_POST["username"], crypt($_POST["password"]), $_POST["email"]);
        
        if ($rows === false)
        {
            apologize("Error: Your username could already exist");
        }
    
        $rows = query("SELECT LAST_INSERT_ID() AS id");
        $_SESSION["id"] = $rows[0]["id"];
        
        $rows = query("INSERT INTO `history` (userid, sourceid, permanent) VALUES(?, 1, 1)", $_SESSION["id"]);
        
        redirect("/");
    }

?>
