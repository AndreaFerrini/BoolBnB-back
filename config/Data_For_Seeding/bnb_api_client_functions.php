<?php

    const base_url  =   "https://api.tomtom.com/search/2/geocode/";
    $api_key        =   env('TOMTOM_API_KEY');
    $error_index    =   0;
    $error_message  =   "";

    function get_coordinates($address, $city)
    {
        global $error_index;
        global $error_message;
        if (isset($address) && $address !== "" && isset($city) && $city !== "")
        {
            
        }
        else
        {
            $error_index = 1;
            $error_message = "Dati insufficienti";
        }
    }