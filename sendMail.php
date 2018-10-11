<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/11
 * Time: 11:06
 */
require_once 'vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.qq.com', 25))
    ->setUsername('166820145@qq.com')
    ->setPassword('omitcavepkvgcbea')
;

// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Wonderful Subject'))
    ->setFrom(['166820145@qq.com' => 'luosilent'])
    ->setTo(['1847291027@qq.com', 'luosilent@139.com' => 'A name'])
    ->setBody('Here is the message itself')
;

// Send the message
$result = $mailer->send($message);

if ($result){
    echo "successful";
}else{
    echo "failed";
}