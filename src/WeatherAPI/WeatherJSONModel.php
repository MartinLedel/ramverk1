<?php

namespace Anax\WeatherAPI;

use DateTime;
use DateInterval;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherJSONModel
{
    protected $apikey1;
    protected $apikey2;
    protected $apikey3;

    /*
    * Sets the api keys from a file
    */
    public function __construct()
    {
        $apiKeys = require ANAX_INSTALL_PATH . "/config/api_keys.php";
        $this->apikey1 = $apiKeys["ipstacks"];
        $this->apikey2 = $apiKeys["darksky"];
        $this->apikey3 = $apiKeys["geocode"];
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
        $apiResult = json_decode($json, true);

        if ($apiResult) {
            return [
                "lat" => $apiResult[0]['lat'],
                "long" => $apiResult[0]['lon'],
                "city" => $apiResult[0]["address"]["city"] ?? "",
                "region" => $apiResult[0]["address"]["state"] ?? "",
                "country" => $apiResult[0]["address"]["country"] ?? ""
            ];
        }

        return [
            "404" => "Error: Couldnt find anything with that search!"
        ];
    }

    /*
    * Using ipstacks to geo search an IP adress
    */
    public function ipCurl($ipAdress)
    {
        $json = [];

        // Initialize CURL:
        $ch = curl_init('http://api.ipstack.com/'. $ipAdress . '?access_key=' . $this->apikey1 . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $apiResult = json_decode($json, true);

        return [
            "lat" => $apiResult["latitude"],
            "long" => $apiResult["longitude"],
            "city" => $apiResult["city"] ?? $apiResult["address"]["village"],
            "region" => $apiResult["region_name"],
            "country" => $apiResult["country_name"]
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
        $ch = curl_init('https://api.darksky.net/forecast/'.$this->apikey2.'/'.$location.'?exclude=minutely,hourly,currently,alerts,flags&extend=daily&lang=sv&units=ca');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $apiResult = json_decode($json, true);

        return [$apiResult];
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
        $date = new Datetime();
        $date->sub(new DateInterval('P'. (intval($day) + 1) .'D'));
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
