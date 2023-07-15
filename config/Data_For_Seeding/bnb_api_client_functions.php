<?php

    use GuzzleHttp\Client as Client;

    const base_url  =   "https://api.tomtom.com/search/2/geocode/";
    $error_index    =   0;
    $error_message  =   "";

    function get_coordinates($address, $city)
    {
        $api_key = env('TOMTOM_API_KEY');
        if (isset($address) && $address !== "" && isset($city) && $city !== "")
        {
            $client_call = new GuzzleHttp\Client(['verify' => false]);
            $end_point = $address . " " . $city . ".json?key=" . $api_key;
            $whole_url = base_url . $end_point;
            $response = $client_call->get($whole_url);
            return $response->getBody()->getContents();
        }
        else
        {
            $error_index = 1;
            $error_message = "Dati insufficienti";
        }
    }

    function add_hours_to_date(int $hours, bool $plus)
    {
        date_default_timezone_set('Europe/Rome');
        $str = "+";
        if (!$plus)
            $str = "-";
        return date('Y-m-d H:i:s', strtotime($str . strval($hours) . " hours"));
    }
