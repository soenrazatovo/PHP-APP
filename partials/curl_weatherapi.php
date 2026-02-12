<?php 
    function getWeatherData(){
        include_once "C:\laragon\www\SLAM\Account\config\curl_config.php";
        include_once "C:\laragon\www\SLAM\Account\config\dotenv.php";
        
        $url = "https://api.openweathermap.org/data/2.5/weather?lat=48.77382115329461&lon=2.0340937365208176&units=metric&appid=".$_ENV["WEATHER_KEY"];
        return curl($url);
    }
?>