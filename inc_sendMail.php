<?php

class Valid
{
    /**
	 * Check an email address for correct format.
	 *
	 * @link  http://www.iamcal.com/publish/articles/php/parsing_email/
	 * @link  http://www.w3.org/Protocols/rfc822/
	 *
	 * @param   string  $email  email address
	 * @param   boolean $strict strict RFC compatibility
	 * @return  boolean
	 */
	public static function email($email, $strict = FALSE)
	{
		if ($email > 254)
		{
			return FALSE;
		}

		if ($strict === TRUE)
		{
			$qtext = '[^\\x0d\\x22\\x5c\\x80-\\xff]';
			$dtext = '[^\\x0d\\x5b-\\x5d\\x80-\\xff]';
			$atom  = '[^\\x00-\\x20\\x22\\x28\\x29\\x2c\\x2e\\x3a-\\x3c\\x3e\\x40\\x5b-\\x5d\\x7f-\\xff]+';
			$pair  = '\\x5c[\\x00-\\x7f]';

			$domain_literal = "\\x5b($dtext|$pair)*\\x5d";
			$quoted_string  = "\\x22($qtext|$pair)*\\x22";
			$sub_domain     = "($atom|$domain_literal)";
			$word           = "($atom|$quoted_string)";
			$domain         = "$sub_domain(\\x2e$sub_domain)*";
			$local_part     = "$word(\\x2e$word)*";

			$expression     = "/^$local_part\\x40$domain$/D";
		}
		else
		{
			$expression = '/^[-_a-z0-9\'+*$^&%=~!?{}]++(?:\.[-_a-z0-9\'+*$^&%=~!?{}]+)*+@(?:(?![-.])[-a-z0-9.]+(?<![-.])\.[a-z]{2,6}|\d{1,3}(?:\.\d{1,3}){3})$/iD';
		}

		return (bool) preg_match($expression, (string) $email);
	}

	/**
	 * Validate the domain of an email address by checking if the domain has a
	 * valid MX record.
	 *
	 * @link  http://php.net/checkdnsrr  not added to Windows until PHP 5.3.0
	 *
	 * @param   string  $email  email address
	 * @return  boolean
	 */
	public static function email_domain($email)
	{
		if ( ! Valid::not_empty($email))
			return FALSE; // Empty fields cause issues with checkdnsrr()

		// Check if the email domain has a valid MX record
		return (bool) checkdnsrr(preg_replace('/^[^@]++@/', '', $email), 'MX');
	}
    
    /**
	 * Checks if a field is not empty.
	 *
	 * @return  boolean
	 */
	public static function not_empty($value)
	{
		if (is_object($value) AND $value instanceof ArrayObject)
		{
			// Get the array from the ArrayObject
			$value = $value->getArrayCopy();
		}

		// Value cannot be NULL, FALSE, '', or an empty array
		return ! in_array($value, array(NULL, FALSE, '', array()), TRUE);
	}    
    
    /**
	 * Checks if a phone number is valid.
	 *
	 * @param   string  $number     phone number to check
	 * @param   array   $lengths
	 * @return  boolean
	 */
	public static function phone($number, $lengths = NULL)
	{
		if ( ! is_array($lengths))
		{
			$lengths = array(7,10,11);
		}

		// Remove all non-digit characters from the number
		$number = preg_replace('/\D+/', '', $number);

		// Check if the number is within range
		return in_array(strlen($number), $lengths);
	}
}

if ($_POST)
{
    $post = array_filter($_POST);
    
    $statusForm = array('status'=>'Error','message'=>'Please complete all required field');
    
    if (!empty($post))
    {
        extract($post);
        if (empty($post_name)) $errors[]    = 'Name is required';
        if (empty($post_email)) $errors[]   = 'Email is required'; elseif (!Valid::email($post_email) || !Valid::email_domain($post_email)) $errors[] = 'Your entered invalid email address. Please check and correct';
        if (empty($post_phone)) $errors[]   = 'Phone is required'; elseif (!Valid::phone($post_phone,array(7,8,9,10,11,12))) $errors[] = 'Your entered invalid phone number. Please check and correct';
        if (empty($post_message)) $errors[] = 'Message is required';
        
        if (!empty($errors)) {$statusForm['message'] = implode('<br/>',$errors); }
        else 
        {
            $statusForm = array('status'=>'Success','message'=>'Thank you. We will contact you soon');
            
            //Send Email
            require_once 'swift/lib/swift_required.php';
            
            $subject    = '[Contact Form] '. $post_name .' contacted you from AXI website';
            
            // Create the Transport
            //$transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
//              ->setUsername('survey20@izkey.com')
//              ->setPassword('webarqcom')
//              ;
           $transport = Swift_SmtpTransport::newInstance();
           
            // Create the Mailer using your created Transport
            $mailer = Swift_Mailer::newInstance($transport);
            
            $mailBody = '<html>'
                            . '<head><title></title></head>'
                            . '<body>'
                                . '<div style="font-family: arial;font-size:11px;color:#333;width:500px;">'
            
                                . '<div style="clear:both;">'
                                    . '<table rules="all" style="border-color: #666;" cellpadding="10">'
                                        . "<tr style='background: #eee;'><td><strong>Subject</strong> </td><td>" . $subject . "</td></tr>"
                                        . "<tr><td><strong>Name</strong> </td><td>" . $post_name . "</td></tr>"
                                        . "<tr><td><strong>Phone</strong> </td><td>" . $post_phone . "</td></tr>"
                                        . "<tr><td><strong>Email</strong> </td><td>" . $post_email . "</td></tr>"
                                        . "<tr><td><strong>Message</strong> </td><td>" . $post_message . "</td></tr>"
                                    . '</table>'
                                . '</div>'
                                . '<div style="font-size:10px;">Do not reply this email</div>'
                            . '</body></html>';
            
            // Create a message
            $message = Swift_Message::newInstance($subject)
              ->setFrom(array('info@email.com' => 'System'))
              ->setTo(array('daniel@webarq.com'=>'Administrator'))      //just add ... , 'some email address'=>'Some Name'
              ->setBody($mailBody, 'text/html')
              ;
            
            // Send the message
            $result = $mailer->send($message);
        }
    }    
       
        
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        echo json_encode($statusForm);
    	die;
    }
} 

