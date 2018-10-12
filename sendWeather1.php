<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/10
 * Time: 11:06
 */

require 'Weather/weather.php';
require 'Mail/sendMail.php';

$getWeather = new Weather();
$sendMail = new sendMail();
$content = $getWeather->getWeather("云霄");
$toMail = "xxx@139.com";
$toName = "luo";
$subject = "每日天气测试";
$mailer = $sendMail->mail($content, $subject, $toMail, $toName);
if ($mailer) {
    echo "send mail successful!";
} else {
    echo "send mail failed!";
}