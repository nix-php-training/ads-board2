<?php

/**
 * Class EmailSender parent
 *
 *
 */
class EmailSender
{
    protected $serverHost;
    protected $mailHost;
    protected $userName;
    protected $userPassword;

    protected $mail;

    protected $to;
    protected $from;
    protected $subject;
    protected $content; // body content

    protected $unique;

    /**
     * Prepared PHPMailer instance
     *
     * @param $to
     */
    protected function __construct($to)
    {
        // get configs
        $this->mailHost = Config::get('mail')['host'];
        $this->userName = Config::get('mail')['username'];
        $this->userPassword = Config::get('mail')['password'];
        $this->serverHost = Config::get('site')['host'];

        // prepare PHPMailer instance
        $this->mail = new PHPMailer(); // create a new object
        $this->mail->IsSMTP(); // enable SMTP
        $this->mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $this->mail->SMTPAuth = true; // authentication enabled
        $this->mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $this->mail->Host = $this->mailHost;
        $this->mail->Port = 465; // or 587
        $this->mail->IsHTML(true);
        $this->mail->Username = $this->userName;//created acc spec for project
        $this->mail->Password = $this->userPassword;//acc of project password(!)

        // set recipient's address
        $this->to = $to;

        // set sender's address
        $this->from = "ads@gmail.com";
    }

    /**
     * Send email
     *
     * @throws Exception
     * @throws phpmailerException
     */
    public function send()
    {
        $this->mail->SetFrom($this->from);
        $this->mail->Subject = $this->subject;
//        $this->mail->Body = file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/application/views/email/layout.phtml');
        $this->mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        h1, h4 {
            color: #ec6851;
        }
    </style>
</head>
<body>
    ' . $this->content . '
    <h4>See you at the <a href="' . $this->serverHost . '">ADS BOARD</a></h4>
</body>
</html>
';
        $this->mail->AddAddress($this->to);
        $result = $this->mail->Send();//sending mail
        if (!$result) {
            throw new  phpmailerException("Mailer Error: " . $this->mail->ErrorInfo);
        }
    }

    public function getUnique()
    {
        return $this->unique;
    }
}

/**
 * Class RegistrationEmail
 *
 * Sends mail for registration
 */
class RegistrationEmail extends EmailSender
{
    public function __construct($to)
    {
        parent::__construct($to);

        $this->unique = Tools::generateUniqueString(44);
        $link = $this->serverHost . "user/confirm?link=" . $this->unique;

        $this->subject = "Registration";

        $this->content = '<h1>Congratulations!</h1>
<p>You were successfully registered on <a href="' . $this->serverHost . '">ADS BOARD</a>.</p>
<p>Please follow next <a href="' . $link . '">link</a> to complete your registration.</p>';
    }
}

/**
 * Class RestoreEmail
 *
 * Sends mail for restore access to account
 */
class RestoreEmail extends EmailSender
{
    public function __construct($to, $password)
    {
        parent::__construct($to);

        $this->unique = Tools::generateUniqueString(44);
        $link = $this->serverHost . "user/login?link=" . $this->unique;

        $this->subject = "Restore password";

        $this->content = '<h1>Greetings!</h1>
<p>We have prepared the new password for you. You can use it for sign in to your account. After sign in, we recommend change the password on your own.
<p>So, your new password is: ' . $password . '</p>
<p>For use the new password you must activate it using this <a href="' . $link . '">' . $link . '</a></p>
<br/>
<p>If you didn\'t do request for change your password, just ignore this message.</p>';
    }
}


/**
 * Sends mail for form Contact us.
 *
 **/

class SendContactEmail extends EmailSender
{
    public function __construct($to, $name, $email, $body)
    {
        parent::__construct($to);

        $this->subject = 'Message from ' . $name . '. Contact Us';

        $this->content = "<h2>$email</h2><p>$body</p>";
    }
}
