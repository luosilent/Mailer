<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/15
 * Time: 15:55
 */
require 'NBAGame/NBA.php';
require 'Mail/sendMail.php';

$getGame = new NBA();
$sendMail = new sendMail();
$content = $getGame->getGame();
$toMail = "xx@qq.com"; //增加收件人邮箱
$toName = "xx"; //收件人昵称
$subject = "NBA赛程提醒"; //邮件主题
$mailer = $sendMail->mail($content, $subject, $toMail, $toName);

if ($mailer) {
    echo "send mail successful!";
} else {
    echo "send mail failed!";
}
