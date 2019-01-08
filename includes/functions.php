<?php

    /**
     * functions.php
     *
     * Computer Science 50
     * Adapted from Problem Set 7
     *
     * Helper functions.
     */

    require_once("constants.php");
    

    /**
     * Apologizes to user with message.
     */
    function apologize($message)
    {
        render("apology.php", ["message" => $message]);
        exit;
    }

    
    /**
     * Facilitates debugging by dumping contents of variable
     * to browser.
     */
    function dump($variable)
    {
        require("../templates/dump.php");
        exit;
    }

    /**
     * Logs out current user, if any.  Based on Example #1 at
     * http://us.php.net/manual/en/function.session-destroy.php.
     */
    function logout()
    {
        // unset any session variables
        $_SESSION = [];

        // expire cookie
        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 42000);
        }

        // destroy session
        session_destroy();
    }


    /**
     * Executes SQL statement, possibly with parameters, returning
     * an array of all rows in result set or false on (non-fatal) error.
     */
    function query(/* $sql [, ... ] */)
    {
        // SQL statement
        $sql = func_get_arg(0);

        // parameters, if any
        $parameters = array_slice(func_get_args(), 1);

        // try to connect to database
        static $handle;
        if (!isset($handle))
        {
            try
            {
                // connect to database
                $handle = new PDO("mysql:dbname=" . DATABASE . ";host=" . SERVER, USERNAME, PASSWORD);

                // ensure that PDO::prepare returns false when passed invalid SQL
                $handle->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            }
            catch (Exception $e)
            {
                // trigger (big, orange) error
                trigger_error($e->getMessage(), E_USER_ERROR);
                exit;
            }
        }

        // prepare SQL statement
        $statement = $handle->prepare($sql);
        if ($statement === false)
        {
            // trigger (big, orange) error
            trigger_error($handle->errorInfo()[2], E_USER_ERROR);
            exit;
        }

        // execute SQL statement
        $results = $statement->execute($parameters);

        // return result set's rows, if any
        if ($results !== false)
        {
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return false;
        }
    }

    /**
     * Redirects user to destination, which can be
     * a URL or a relative path on the local host.
     *
     * Because this function outputs an HTTP header, it
     * must be called before caller outputs any HTML.
     */
    function redirect($destination)
    {
        // handle URL
        if (preg_match("/^https?:\/\//", $destination))
        {
            header("Location: " . $destination);
        }

        // handle absolute path
        else if (preg_match("/^\//", $destination))
        {
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            header("Location: $protocol://$host$destination");
        }

        // handle relative path
        else
        {
            // adapted from http://www.php.net/header
            $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
            $host = $_SERVER["HTTP_HOST"];
            $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
            header("Location: $protocol://$host$path/$destination");
        }

        // exit immediately since we're redirecting anyway
        exit;
    }

    /**
     * Renders template, passing in values.
     */
    function render($template, $values = [])
    {
        
        // if template exists, render it
        if (file_exists(__DIR__ . "/../templates/$template"))
        {
            // extract variables into local scope
            extract($values);

            
            
            // render header
            require(__DIR__ . "/../templates/header.php");

            // render template
            require(__DIR__ . "/../templates/$template");

            // render footer
            require(__DIR__ . "/../templates/footer.php");
        }

        // else err
        else
        {
            trigger_error("Invalid template: $template", E_USER_ERROR);
        }
    }

    /*
    * emailVerify is a PHP function that can be easily used to verify an email address 
    * and make sure it is valid and does exist on the mail server.
    * From: https://github.com/hbattat/verifyEmail/blob/master/verify.php
    */
    function verifyEmail($toemail, $fromemail, $getdetails = false)
    {
	    $email_arr = explode("@", $toemail);
	    $domain = array_slice($email_arr, -1);
	    $domain = $domain[0];
	    $details = "";

	    // Trim [ and ] from beginning and end of domain string, respectively
	    $domain = ltrim($domain, "[");
	    $domain = rtrim($domain, "]");

	    if( "IPv6:" == substr($domain, 0, strlen("IPv6:")) ) 
	    {
		    $domain = substr($domain, strlen("IPv6") + 1);
	    }

	    $mxhosts = array();
	    if( filter_var($domain, FILTER_VALIDATE_IP) )
		    $mx_ip = $domain;
	    else
		    getmxrr($domain, $mxhosts, $mxweight);

	    if(!empty($mxhosts) )
		    $mx_ip = $mxhosts[array_search(min($mxweight), $mxhosts)];
	    else 
	    {
		    if( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ) 
		    {
			    $record_a = dns_get_record($domain, DNS_A);
		    }
		    elseif( filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ) 
		    {
			    $record_a = dns_get_record($domain, DNS_AAAA);
		    }

		    if( !empty($record_a) )
			    $mx_ip = $record_a[0]['ip'];
		    else 
		    {

			    $result   = "invalid";
			    $details .= "No suitable MX records found.";

			    return ( (true == $getdetails) ? array($result, $details) : $result );
		    }
	    }
	
	    $connect = @fsockopen($mx_ip, 25); 
	    if($connect){ 
		    if(preg_match("/^220/i", $out = fgets($connect, 1024)))
		    {
			    fputs ($connect , "HELO $mx_ip\r\n"); 
			    $out = fgets ($connect, 1024);
			    $details .= $out."\n";
     
			    fputs ($connect , "MAIL FROM: <$fromemail>\r\n"); 
			    $from = fgets ($connect, 1024); 
			    $details .= $from."\n";

			    fputs ($connect , "RCPT TO: <$toemail>\r\n"); 
			    $to = fgets ($connect, 1024);
			    $details .= $to."\n";

			    fputs ($connect , "QUIT"); 
			    fclose($connect);

			    if(!preg_match("/^250/i", $from) || !preg_match("/^250/i", $to))
			    {
				    $result = "invalid"; 
			    }
			    else
			    {
				    $result = "valid";
			    }
		    } 
	    }
	    else
	    {
		    $result = "invalid";
		    $details .= "Could not connect to server";
	    }
	    if($getdetails)
	    {
		    return array($result, $details);
	    }
	    else
	    {
		    return $result;
	    }
    }   
    
    /*
    * Sends an e-mail using PHPMAiler and GMail's SMTP server
    * Based on SMTP example from PHPMailer's Github: 
    * https://github.com/Synchro/PHPMailer/blob/master/examples/smtp.phps
    * Returns true on successful sending of e-mail, false on (non-fatal) error
    */ 
    function email($from, $to, $subject, $body)
    {
        try 
        {
              
            $mail = new PHPMailer();
            
            // telling the class to use SMTP
            $mail->IsSMTP();                     
            
            $mail->SMTPDebug = 0;
            // enable SMTP authentication
            $mail->SMTPAuth   = true;                  
            
            // sets the prefix to the servier
            $mail->SMTPSecure = "tls";                 
            
            // sets GMAIL as the SMTP server
            $mail->Host       = "smtp.gmail.com";      
            
            // set the SMTP port for the GMAIL server
            $mail->Port       = 587;                   
            $mail->Username   = "2251784@gmail.com";  // GMAIL username
            $mail->Password   = "hossoalgamed";            // GMAIL password

            $mail->SetFrom('2251784@gmail.com', $from);
            
            $mail->Subject    = $subject;

            $mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 

            $mail->MsgHTML($body);

            $mail->AddAddress($to);

            $mail->Send();
            return true;
        } 
        catch (phpmailerException $e) 
        {
            trigger_error($e->errorMessage(), E_USER_ERROR);
            return false;
            
        } 
        catch (Exception $e) 
        {
            trigger_error($e->getMessage(), E_USER_ERROR);
            return false;
        }
    }
    
    function formatNumber($num, $percision=0) 
    {
    	global $SUFFIXES;
   
    	if ($num < 1000000)
        {
              $percision = 0;
        }

        $ans = "";
    	$number = $num;
    	$count = 0;
    	
    	if ($number < 1000000)
    	{
    		$ans = number_format($number, $percision);
    	}
    	else
    	{
    	
			while($number >= 1000)
			{
				$number /= 1000;
				$count++;
			}
			if ($count <= 21)
			{
				$ans = number_format($number, $percision) . " " . $SUFFIXES[$count-2] . "illion";
			}
			else
			{
				$number /= 1000;
				$count++;
				$ans = number_format($number, 2) . 'e' . (($count) * 3);
			}
			
		}

    	return $ans;
    }
?>
	