<?php

namespace Anax\WeatherAPI;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class weatherJSONModel
{
    protected $apikey1;
    protected $apikey2;
    protected $apikey3;

    /*
    * Sets the api keys from a file
    */
    public function __construct()
    {
        $api_keys = require ANAX_INSTALL_PATH . "/config/api_keys.php";
        $this->apikey1 = $api_keys["ipstacks"];
        $this->apikey2 = $api_keys["darksky"];
        $this->apikey3 = $api_keys["geocode"];
    }

    /*
    * Using nominatim to geo search an adress
    */
    public function geocode($address)
    {
        $adrsurl = urlencode($address);
        $json = [];

        // Initialize CURL:
        $ch = curl_init("https://nominatim.openstreetmap.org/?format=json&addressdetails=1&q={$adrsurl}&limit=1&email=email@live.se");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);

        if ($api_result) {
            return [
                "lat" => $api_result[0]['lat'],
                "long" => $api_result[0]['lon'],
                "city" => $api_result[0]["address"]["city"] ?? $api_result[0]["address"]["village"],
                "region" => $api_result[0]["address"]["state"],
                "country" => $api_result[0]["address"]["country"]
            ];
        }

        return [
            "404" => "Error: Couldnt find anything with that search!"
        ];
    }

    /*
    * Using ipstacks to geo search an IP adress
    */
    public function ipCurl($ip)
    {
        $json = [];

        // Initialize CURL:
        $ch = curl_init('http://api.ipstack.com/'. $ip . '?access_key=' . $this->apikey1 . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);

        return [
            "lat" => $api_result["latitude"],
            "long" => $api_result["longitude"],
            "city" => $api_result["city"] ?? $api_result["address"]["village"],
            "region" => $api_result["region_name"],
            "country" => $api_result["country_name"]
        ];
    }

    /*
    * Fetching weather
    */
    public function fetchCurrentWeather($coords)
    {
        $json = [];
        $location = $coords["lat"] . ',' . $coords["long"];

        // Initialize CURL:
        $ch = curl_init('https://api.darksky.net/forecast/'.$this->apikey2.'/'.$location.'?exclude=minutely,hourly,currently,alerts,flags&extend=daily&lang=sv&units=auto');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);

        return [$api_result];
    }

    /*
    * Fetching weather
    */
    public function fetchPrevWeather($coords, $days)
    {
        $json = [];
        $res = $this->multiCurl($coords, $days);
        foreach ($res as $day) {
            $json[] = $day["daily"]["data"];
        }

        return [$json];
    }

    /*
    * Method for setting up multi curl
    */
    public function multiCurl($coords, $days)
    {
        $urls = $this->getUrls($coords, $days);

        $mCurl = curl_multi_init();
        $handles = [];
        $json = [];
        foreach ($urls as $url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_multi_add_handle($mCurl, $ch);
            $handles[$url] = $ch;
        }
        $this->startMultiCurl($mCurl);
        foreach ($handles as $channel) {
            $html = curl_multi_getcontent($channel);
            $json[] = json_decode($html, true);
            curl_multi_remove_handle($mCurl, $channel);
        }
        curl_multi_close($mCurl);
        return $json;
    }

    /*
    * Method for getting all urls for the multi curl method
    */
    private function getUrls($coords, $days) : array
    {
        $urls = [];
        $location = $coords["lat"] . ',' . $coords["long"];
        for ($i = 0; $i < $days; $i++) {
            $time = $this->getDayFormat("$i");
            $urls[] = 'https://api.darksky.net/forecast/'.$this->apikey2.'/'.$location.','.$time.'?exclude=minutely,hourly,currently,alerts,flags&extend=daily&lang=sv&units=auto';
        }
        return $urls;
    }

    /*
    * Method for converting time/date to correct format for darksky api
    */
    public function getDayFormat($day)
    {
        $date = new \Datetime();
        $date->sub(new \DateInterval('P'. (intval($day) + 1) .'D'));
        return $date->format('U');
    }

    /*
    * Method for actually fetching the multi curls
    */
    public function startMultiCurl($mCurl)
    {
        do {
            $mrc = curl_multi_exec($mCurl, $active);
        } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        while ($active && $mrc == CURLM_OK) {
            if (curl_multi_select($mCurl) == -1) {
                usleep(100);
            }
            do {
                $mrc = curl_multi_exec($mCurl, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }
}
