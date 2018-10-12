<?php

/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/12
 * Time: 9:18
 */
class Weather
{
    private static $key = '8ba0b2b43f49427e9f549d95418d9dce';
    private static $url = 'https://free-api.heweather.com/s6/weather/forecast';

    public function getWeather($location)
    {
        $key = self::$key;
        $url = self::$url;
        $apiUrl = $url . "?location=" . $location . "&key=" . $key;
        $output = file_get_contents($apiUrl);
        $res = json_decode($output, true);
        $base = $res['HeWeather6'][0]['basic'];
        $update = $res['HeWeather6'][0]['update'];
        $city = $base['location'];//城市名称
        $parent_city = $base['parent_city'];//城市的上级城市
        $loc = $update['loc'];//更新时间
        $re = array();
        for ($i = 0; $i <= 3; $i++) {
            $daily_forecast = $res['HeWeather6'][0]['daily_forecast'][$i];

            $cond_txt_d = $daily_forecast['cond_txt_d'];//白天天气
            $cond_txt_n = $daily_forecast['cond_txt_n'];//晚间天气
            $tmp_max = $daily_forecast['tmp_max'] . "℃";//最高温度
            $tmp_min = $daily_forecast['tmp_min'] . "℃";//最低温度
            $wind_dir = $daily_forecast['wind_dir'];//风向
            $wind_sc = $daily_forecast['wind_sc'] . "级";//风力
            $pop = $daily_forecast['pop'] . "%";//降水概率
            $pcpn = $daily_forecast['pcpn'];//降水量
            $sr = $daily_forecast['sr'];//日出时间
            $ss = $daily_forecast['ss'];//日落时间

            $re[] = <<<EOF
        $parent_city $city
            白天天气:$cond_txt_d
            晚间天气:$cond_txt_n
            最高温度:$tmp_max 
            最低温度:$tmp_min 
            降水概率:$pop 会下雨
            降水量:$pcpn
            风向:$wind_dir
            风力:$wind_sc 
            日出时间:$sr
            日落时间:$ss
            更新时间:$loc
EOF;

        }

        $content = <<<EOF
        
        今天
        $re[0]
        
        明天
        $re[1]
        
        后天       
        $re[2];
EOF;

        return $content;
    }
}

//$getWeather = new Weather();
//
//$content = $getWeather->getWeather("杭州");
//print_r($content);