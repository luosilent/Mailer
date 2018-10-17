<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/15
 * Time: 10:48
 */

class NBA
{
    public function getGameData($url)
    {
        $res = $this->setRequest($url);
        $pattern1 = '/<td colspan=\"3\" class=\"left\" width=\"135\">(.*)<tr class=\"left linglei\">/isU';
        preg_match_all($pattern1, $res, $matches1);
        $resDate = array_unique($matches1[0]);//赛程包含日期和球队
        $resGames = array();
        foreach ($resDate as $key => $value) {
            $games = array();
            $pattern2 = '/<td colspan=\"3\" class=\"left\" width=\"135\">(.*)<\/td>/isU';
            preg_match_all($pattern2, $value, $matches2);
            $gameDate0 = $matches2[1][0];//日期
            $gameDate1 = substr($gameDate0, 0, 10);
            $gameDate2 = substr($gameDate0, -9, 10);
            $gameDate = $gameDate1 . " " . $gameDate2;
            $pattern3 = '/<tr class=\"left\">(.*)<\/tr>/isU';
            preg_match_all($pattern3, $value, $matches3);
            $gameRes = $matches3[0];
            foreach ($gameRes as $k => $v) {
                $pattern4 = '/<td class=\"left\" width=\"135\">(.*)<\/td>/isU';
                preg_match_all($pattern4, $v, $matches4);
                $gameTime = $matches4[1][0];//具体时间
                $pattern5 = '/<a href=\"(.*?)\".*?>(.*)<\/a>(.*)<a href=\"(.*?)\".*?>(.*)<\/a>/iU';
                preg_match_all($pattern5, $v, $matches5);
                $player1 = $matches5[2][0];//球队1
                $vs = " vs ";//vs
                $player2 = $matches5[5][0];//球队2
                $games[$k] = $gameDate . " " . $gameTime . " " . $player1 . $vs . $player2;
            }
            $resGames[$key] = $games;
        }

        return $resGames;
    }


    /** curl抓取HTML
     * @param $url
     * @return mixed
     */
    public function setRequest($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_COOKIEFILE, "cookiefile");
        curl_setopt($curl, CURLOPT_COOKIEJAR, "cookiefile"); # SAME cookiefile
        curl_setopt($curl, CURLOPT_URL, $url); # this is where you first time connect - GET method authorization in my case, if you have POST - need to edit code a bit
        $xxx = curl_exec($curl);

        curl_close($curl);

        return $xxx;
    }

    public function getGame()
    {
        $day = date("Y-m-d");
        $today = date('m月d日');
        $games = $this->getGameData("http://nba.hupu.com/schedule/$day");
        print_r($games);
        $gameDate = substr($games[0][0], 0, 10);
        $lent0 = count($games[0]);
        $lent1 = count($games[1]);
        $lent2 = count($games[2]);
        if ($today != $gameDate) {
            $resGame = "今天$today 没有比赛" . PHP_EOL;
        } else {
            $resGame = "今日$today 赛程" . PHP_EOL;
        }
        $resGame .= PHP_EOL;
        for ($i = 0; $i < $lent0; $i++) {
            $t1 = $games[0][$i];
            $resGame .= $t1 . PHP_EOL;
        }
        $resGame .= PHP_EOL;
        for ($j = 0; $j < $lent1; $j++) {
            $t2 = $games[1][$j];
            $resGame .= $t2 . PHP_EOL;
        }
        $resGame .= PHP_EOL;
        for ($k = 0; $k < $lent2; $k++) {
            $t3 = $games[2][$k];
            $resGame .= $t3 . PHP_EOL;
        }

        return $resGame;
    }

}
