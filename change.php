<?php

    //configuration
    require("includes/config.php");
    
    // if user tried to change password using e-mail while logged in
    if (isset($_GET["m"]) and $_GET["m"] == "e" and isset($_SESSION["id"]))
    {
        // complain
        apologize("Please change your password through the link on your profile.");
    }
    
    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // if user reached page via portfolio
        if ($_GET["m"] == "p")
        {       
            // render form
            render("change_form.php", ["title" => "Change Password", "mode" => $_GET["m"], "id" => $_SESSION["id"]]);
        }
        
        // if user reached page using Forgot Password
        elseif ($_GET["m"] == "e")
        {
        	// render form
            render("change_form.php", ["title" => "Reset Password", "mode" => $_GET["m"], "id" => -1]);
        }
        
        // if user reached page via e-mail link
        elseif ($_GET["m"] == "v")
        {
            // validate submission: HTTP parameters are not empty
            if (empty($_GET["t"]) or empty($_GET["id"]))
            {
                apologize("Invalid URL");
            }
            
            // validate submission: token is still valid
            $date = substr($_GET["t"], -8);
            if ($date != date("dWmy"))
            {
                // expire token
                query("UPDATE `users` SET token = NULL WHERE id = ?", $_GET["id"]);
                apologize("Your token has expired.");                    
            }
            
            // validate submission: user's information
            $rows = query("SELECT * FROM `users` WHERE token = ? AND id = ?", $_GET["t"], $_GET["id"]);
            if (count($rows) != 1)
            {
                apologize("Invalid token");
            }
            
            render("change_form.php", ["title" => "Change Password", "mode" => $_GET["m"], "id" => $_GET["id"]]); 
        }
        else
        {
            apologize("Unauthorized access.");
        }
    }
    
    // if user reached page by POST (as by submitting a form)
    elseif ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // if user is logged in or if user reached page after e-mail link
        if ($_POST["mode"] == "p" or $_POST["mode"] == "v")
        {
            // ensure user fills all form fields
            if (empty($_POST["new"]) or empty($_POST["confirmation"]))
            {
                apologize("One or more form fields are empty");
            }
            
            if ($_POST["mode"] == "p" and empty($_POST["old"]))
            {
                apologize("One or more form fields are empty");
            }
            
            // ensure password and confirmation match
            if ($_POST["new"] != $_POST["confirmation"])
            {
                apologize("The new passwords you entered do not match");
            }
            
            
            if ($_POST["mode"] == "p")
            {
                // validate old password
                $user = query("SELECT hash FROM `users` WHERE id = ?", $_SESSION["id"]);
                if (count($user) != 1)
                {
                    apologize("An unkown error occured.");
                }
                if ($_POST["mode"] == "p" and crypt($_POST["old"], $user[0]["hash"]) != $user[0]["hash"])
                {
                    apologize("Wrong old password");
                }
            }
            
            // change password
            query("UPDATE `users` SET hash = ? WHERE id = ?", crypt($_POST["new"]), $_POST["id"]);
            render("change_success.php", ["title" => "Success!", "message" => "Your password was successfully changed."]);
        }
        
        // if user forgot password
        elseif ($_POST["mode"] == "e")
        {
            // validate submission
            if (empty($_POST["email"]))
            {
                apologize("You must provide your e-mail address");
            }
            elseif (verifyEmail($_POST["email"], "harrypotter1061999@hotmail.com") == "invalid")
            {
                apologize("Invalid e-mail address");
            }
            
            // lookup user's e-mail
            $rows = query("SELECT * FROM `users` WHERE email = ?", $_POST["email"]);
            if (count($rows) != 1)
            {
                apologize("There is no user registered with this email.");
            }
            
            // generate token and register in database
            $string = $rows[0]["id"] . $rows[0]["username"] . rand() . $rows[0]["hash"];
            $token = crypt($string, rand());
            $token .= date("dWmy");
            query("UPDATE `users` SET token = ? WHERE id = ?", $token, $rows[0]["id"]);
            
            // send email with link
            $message   = array();
            $message[] = "<a href=\"lightsource/\"><img alt=\"LightSource\" src=\"lightsource/img/translogo.png\"/></a>";
            $message[] = "<h4>Dear customer, </h4>";
            $message[] = "<h4>  A request to change your password was made. If you didn't request a password change, please ignore this email.<h4>";
            $message[] = "<h4>  Otherwise, please follow the link below: </h4>";
            $message[] = "http://lightsource/change.php?m=v&t=$token&id={$rows[0]["id"]}";
            if (email("LightSource", $rows[0]["email"], "Password Change", implode("<br/>", $message)))
            {
                render("change_success.php", ["title" => "Success!", "message" => "An e-mail was sent with a link to change your password"]);
            }
            else
            {
                apologize("Error sending an e-mail. Please try again.");
            }
        }   
    }
?>
