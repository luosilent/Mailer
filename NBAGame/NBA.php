<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/15
 * Time: 10:48
 */

class NBA
{

    public function getGameDate($url)
    {
        $res = $this->setRequest($url);
        $pattern1 = '/<td colspan=\"3\" class=\"left\" width=\"135\">(.*?)<tr class=\"left linglei\">/is';
        preg_match_all($pattern1, $res, $matches1);
        $resDate = array_unique($matches1[0]);
        $games = array();
        $resGames = array();
        foreach ($resDate as $key => $value) {
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
                $pattern5 = '/<a href=\"(.*?)\".*?>(.*?)<\/a>(.*)<a href=\"(.*?)\".*?>(.*?)<\/a>/i';
                preg_match_all($pattern5, $v, $matches5);
                $game1 = $matches5[2][0];//球队1
                $vs = " vs ";//vs
                $game2 = $matches5[5][0];//球队2
                $games[$k] = $gameDate . " " . $gameTime . " " . $game1 . $vs . $game2;
            }
            $resGames[] = $games;
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
        $test = "10月18日";
        $games = $this->getGameDate("http://nba.hupu.com/schedule/2018-10-19");
        $gameDate = substr($games[0][0], 0, 10);
        $lent0 = count($games[0]);
        $lent1 = count($games[1]);
        $lent2 = count($games[2]);
        $resGame = array();
        if ($test != $gameDate) {
            $t0 = "NBA今天没有比赛 ";
        } else {
            $t0 = "NBA今日赛程 ";
        }
        $resGame['t0'][0] = <<<EOF
$t0
EOF;
        for ($i = 0; $i < $lent0; $i++) {
            $t1 = $games[0][$i];
            $resGame['t1'][] = <<<EOF
$t1
EOF;
        }
        for ($j = 0; $j < $lent1; $j++) {
            $t2 = $games[1][$j];
            $resGame['t2'][] = <<<EOF
$t2
EOF;
        }
        for ($k = 0; $k < $lent2; $k++) {
            $t3 = $games[2][$k];
            $resGame['t3'][] = <<<EOF
$t3
EOF;
        }


        return $resGame;
    }

}

$test = new NBA();
$get = $test->getGame();
print_r($get);