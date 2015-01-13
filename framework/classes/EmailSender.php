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

    public function send()
    {
        $this->mail->SetFrom($this->from);
        $this->mail->Subject = $this->subject;
        $this->mail->Body = '
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <style>
        .wrap {
            text-align: center;
        }

        h1, h5 {
            color: #ec6851;
        }

        a:link, a:visited {
            color: #656D78;
        }

        a:hover, a:active {
            color: #434A54;
        }
    </style>
</head>
<body>
<div class="wrap">
    ' . $this->content . '
    <h5>See you at the <a href="' . $this->serverHost . '">ADS BOARD</a></h5>
</div>
</body>
</html>
';
        $this->mail->AddAddress($this->to);
        $result = $this->mail->Send();//sending mail
        if (!$result) {
            throw new  Exception("Mailer Error: " . $this->mail->ErrorInfo);
        }
    }

    protected function generateUnique()
    {
        $num = 44;
        $unique = '';

        $arr = array(
            'a',
            'b',
            'c',
            'd',
            'e',
            'f',
            'g',
            'h',
            'i',
            'j',
            'k',
            'l',
            'm',
            'n',
            'o',
            'p',
            'r',
            's',
            't',
            'u',
            'v',
            'x',
            'y',
            'z',
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            'H',
            'I',
            'J',
            'K',
            'L',
            'M',
            'N',
            'O',
            'P',
            'R',
            'S',
            'T',
            'U',
            'V',
            'X',
            'Y',
            'Z',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '0',
        );

        for ($i = 1; $i <= $num; $i++) {
            $index = mt_rand(0, count($arr) - 1);
            $unique .= $arr[$index];
        }

        return $unique;
    }

    protected function getUnique()
    {
        return $this->unique;
    }
}

class RegistrationEmail extends EmailSender
{
    public function __construct($to)
    {
        parent::__construct($to);

        $this->unique = $this->generateUnique();
        $link = $this->serverHost . "user/confirm?link=' . $this->unique . '";

        $this->subject = "Registration";

        $this->content = '<h1>Congratulations!</h1>
<p>You were successfully registered on <a href="' . $this->serverHost . '">ADS BOARD</a>.</p>
<p>Please follow next <a href="' . $link . '">link</a> to complete your registration.</p>';
    }
}

class RestoreEmail extends EmailSender
{
    public function __construct($to)
    {
        parent::__construct($to);

        $this->unique = $this->generateUnique();
        $link = $this->serverHost . "user/login?link=' . $this->unique . '";

        $this->subject = "Restore password";

        $this->content = '<h1>Greetings!</h1>
<p>We have prepared the new password for you.</p>
<p>You can use it for sign in to your account.</p>
<p>After sign in, we recommend change the password on your own.</p>
<p>So, your new password is: </p>
<p>For use the new password you must activate it using this <a href="' . $link . '">link</a></p>
<br/>
<p>If you didn\'t do request for change your password, just ignore this message.</p>';
    }
}