<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/11
 * Time: 11:06
 */
require_once 'F:/PHPWAMP_IN1/wwwroot/Mailer/vendor/autoload.php';

class sendMail
{
    private static $username = '166820145@qq.com';
    private static $key = 'omitcavepkvgcbea';
    private static $my = 'luosilent';
    private static $toMail1 = '1847291027@qq.com';
    private static $toMail2 = 'luosilent@139.com';
    private static $toName1 = 'lcg';
    private static $toName2 = 'llg';

    public function mail($content,$subject)
    {
        $transport = (new Swift_SmtpTransport('smtp.qq.com', 25))
            ->setUsername(self::$username)
            ->setPassword(self::$key);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message("$subject"))
            ->setFrom([self::$username => self::$my])
            ->setTo([ self::$toMail1=> self::$toName1, self::$toMail2 => self::$toName2])
            ->setBody("$content");

        $result = $mailer->send($message);

        return $result;
    }
}