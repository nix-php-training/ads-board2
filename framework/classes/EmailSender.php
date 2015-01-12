<?php

class EmailSender
{
    public $unique;

    public function sendMail($to)
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
        $this->unique = $unique;
        $uniqueQuery = Config::get('site')['host'] . "user/confirm?link=$unique";

        $link = "<a href = $uniqueQuery>" . $uniqueQuery . "</a>";

        $mail = new PHPMailer(); // create a new object
        $mail->IsSMTP(); // enable SMTP
        $mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth = true; // authentication enabled
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465; // or 587
        $mail->IsHTML(true);
        $mail->Username = "adsboard2@gmail.com";//created acc spec for project
        $mail->Password = "Ads-Board2.zone";//acc of project password(!)
        $mail->SetFrom("example@gmail.com");
        $mail->Subject = "Registration";
        $mail->Body = "Congratulations you were successfully registered on ads-board2.zone, please follow next link $link to complete your registration";
        $mail->AddAddress($to);
        $mail->Send();//sending mail
        /*if(!$mail->Send())
        {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
        else
        {
            echo "Message has been sent";
        }*/
    }
}