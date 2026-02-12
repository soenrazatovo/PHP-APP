<?php
    function curl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        $resp = curl_exec($ch);
        if ($e = curl_error($ch)) {
            var_dump($e);
        } else {}
            $data = json_decode($resp, true);
            curl_close($ch);
            return $data;
    }
?>