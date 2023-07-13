<?php

    use GuzzleHttp\Client as Client;

    const base_url  =   "https://api.tomtom.com/search/2/geocode/";
    const api_key   =   'H87cql0ALbfterWC1evVSLYCYtbFAkxd';
    $error_index    =   0;
    $error_message  =   "";

    function get_coordinates($address, $city)
    {
        if (isset($address) && $address !== "" && isset($city) && $city !== "")
        {
            $client_call = new GuzzleHttp\Client(['verify' => false]);
            $end_point = $address . "" . $city . ".json?key=" . api_key;
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