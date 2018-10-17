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
    private static $username = 'xx@qq.com'; //发件人邮箱
    private static $key = 'xx'; //发件人邮箱开启SMTP，获取验证码
    private static $my = 'Lcg'; //发件人昵称
    private static $toMail1 = 'xxxx@qq.com'; //默认收件人邮箱
    private static $toName1 = 'xxx'; //默认收件人昵称


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
