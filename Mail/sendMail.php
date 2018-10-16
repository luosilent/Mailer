<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/11
 * Time: 11:06
 */
define('ROOT_PATH', dirname(dirname(__FILE__)));
require ROOT_PATH.'/vendor/autoload.php';

class sendMail
{
    private static $username = 'luosilent@qq.com';
    private static $key = 'eqjqdzgwusyiceaf';
    private static $my = 'Lcg';
    private static $toMail1 = '166820145@qq.com';
    private static $toName1 = 'lcg';


    public function mail($content,$subject,$toMail2,$toName2)
    {
        $transport = (new Swift_SmtpTransport('smtp.qq.com', 25))
            ->setUsername(self::$username)
            ->setPassword(self::$key);

        $mailer = new Swift_Mailer($transport);

        $message = (new Swift_Message("$subject"))
            ->setFrom([self::$username => self::$my])
            ->setTo([ self::$toMail1=> self::$toName1, $toMail2 => $toName2])
            ->setBody("$content");

        $result = $mailer->send($message);

        return $result;
    }
}