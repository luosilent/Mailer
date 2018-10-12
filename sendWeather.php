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
$content = $getWeather -> getWeather("杭州");


$subject = "每日天气";
$mailer = $sendMail -> mail("$content",$subject);