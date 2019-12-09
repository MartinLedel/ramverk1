<?php

namespace Anax\WeatherAPI;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherModel
{
    public $model;

    /*
    * Getting the model
    */
    public function __construct()
    {
        $this->model = new WeatherJSONModel();
    }

    /*
    * Method choosing whether geo searching on ip or adress
    */
    public function getWeatherData($session, $searchReq, $days)
    {
        $json = null;
        if (filter_var($searchReq, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $coords = $this->model->ipCurl($searchReq);
            $session->set("address", $coords);
            if (!isset($coords["404"])) {
                $json = $this->fetchAll($coords, $days);
                $session->set("jsonData", $json);
            }
        } elseif (is_string($searchReq)) {
            $coords = $this->model->geocode($searchReq);
            $session->set("address", $coords);
            if (!isset($coords["404"])) {
                $json = $this->fetchAll($coords, $days);
                $session->set("jsonData", $json);
            }
        }
    }

    /*
    * Method for fetching either current weather or 30 previous days
    */
    public function fetchAll($coords, $days)
    {
        $json = [];
        if ($days == "0") {
            $json["current"] = $this->model->fetchCurrentWeather($coords);
            $json["previous"] = null;
        } elseif ($days == "30") {
            $json["current"] = $this->model->fetchCurrentWeather($coords);
            $json["previous"] = $this->model->fetchPrevWeather($coords, $days);
        }
        return [
            "current" => $json["current"],
            "previous" => $json["previous"],
        ];
    }

    /*
    * Method for $di
    */
    public function welcomeMsg()
    {
        $json = null;

        $json["message"] = "Välkommen till Väder API. Sök på tex. Karlskrona eller Karlskrona, Sverige. Även
        en IP adress går bra tex. 8.8.8.8.<br>";

        return $json;
    }
}
