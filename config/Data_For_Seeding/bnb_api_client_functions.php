<?php

    use GuzzleHttp\Client as Client;
    use Illuminate\Support\Facades\Storage as Storage;
    use Illuminate\Support\Str;

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

    function add_hours_to_date(int $hours, $plus = true)
    {
        date_default_timezone_set('Europe/Rome');
        $str = "+";
        if (!$plus)
            $str = "-";
        if ($hours != 0)
            $date_argument = strtotime($str . strval($hours) . " hours");
        else
            $date_argument = time();
        return date('Y-m-d H:i:s', $date_argument);
    }

    function pictures_from_storage($storage_folder, $apartment_id)
    {
        $result_array = [];
        $all_files = Storage::files($storage_folder);
        foreach ($all_files as $single_file)
        {
            $filename = pathinfo($single_file, PATHINFO_FILENAME);
            $lowercase_filename = strtolower($filename);
            $str_id = strval($apartment_id);
             if (Str::startsWith($lowercase_filename, "id{$str_id}_"))
                $result_array[] = $storage_folder . "/" . $filename;
        }
        if (count($result_array) > 1)
            sort($result_array);
        return $result_array;
    }