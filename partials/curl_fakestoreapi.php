<?php
    function getProduct($productId = "") {
        include_once "C:\laragon\www\SLAM\Account\config\curl_config.php";

        $url = 'https://fakestoreapi.com/products/'.$productId;
        return curl($url);
    }
?>