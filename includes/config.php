<?php

    /**
     * config.php
     *
     * Computer Science 50
     * Borrowed from Problem Set 7 with modifications
     *
     * Configures pages.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");
    require("phpMailer/PHPMailerAutoload.php");

    // enable sessions
    session_start();

    // require authentication for all pages except /login.php, /logout.php, /register.php and /change.php
    if ($_SERVER["PHP_SELF"] == "/change.php")
    {
        if (isset($_GET["m"]))
        {
            if ($_GET["m"] != "e" and $_GET["m"] != "v" and empty($_SESSION["id"]))
            {
                redirect("login.php");
            }
        }
        else if (isset($_POST["m"]))
        {
            if ($_POST["m"] != "e" and $_POST["m"] != "v" and empty($_SESSION["id"]))
            {
                redirect("login.php");
            }
        }
    } 
    if (!in_array($_SERVER["PHP_SELF"], ["/login.php", "/logout.php", "/register.php", "/change.php"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
