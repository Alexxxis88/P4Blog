<?php
class FormController
{
    public function sendMessage($firstName, $lastName, $contactEmail, $topic, $messageContent)
    {
        $to  = 'alexisxgautier@gmail.com, jean-forteroche@jeanforteroche.com';
        $message = '
        <html>
            <body>
                <p>' .  $messageContent . '</p>
            </body>
        </html>
        ';
        // Headers Content-type must be defined to send an HTML email
        $headers[] = 'MIME-Version: 1.0';
        $headers[] = 'Content-type: text/html; charset=iso-8859-1';

        // Additional headers
        $headers[] = 'To: Alexis <alexisxgautier@gmail.com>, Jean <jean-forteroche@jeanforteroche.com>';
        $headers[] = 'From: ' . $firstName . ' '. $lastName . '<'. $contactEmail . '>';
        mail($to, $topic, $message, implode("\r\n", $headers));

        header('Location: index.php?success=3#header');
        exit;
    }
}
