<?php
/**
 * Created by PhpStorm.
 * User: luosilent
 * Date: 2018/10/12
 * Time: 16:07
 */
require_once('lunar.php');
$solar = new Solar();
$solar->solarYear = 2018;
$solar->solarMonth = 10;
$solar->solarDay = 12;
$lunar = LunarSolarConverter::SolarToLunar($solar);
print_r($lunar);
$solar = LunarSolarConverter::LunarToSolar($lunar);
print_r($solar);