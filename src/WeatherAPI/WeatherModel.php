<?php

namespace Anax\WeatherAPI;

/**
 * Showing off a standard class with methods and properties.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class weatherModel
{
    public $model;

    public function __construct()
    {
        $this->model = new weatherJSONModel();
    }

    public function getWeatherData($session, $searchReq, $days)
    {
        $json = null;
        if (filter_var($searchReq, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
            $coords = $this->model->ipCurl($searchReq);
            if (!isset($coords["error"])) {
                $json = $this->fetchAll($coords, $days);
                $session->set("jsonData", $json);
            }
            $session->set("address", $coords);
        } elseif ($searchReq) {
            $coords = $this->model->geocode($searchReq);
            if (!isset($coords["error"])) {
                $json = $this->fetchAll($coords, $days);
                $session->set("jsonData", $json);
            }
            $session->set("address", $coords);
        }
    }

    public function fetchAll($coords, $days)
    {
        $json = [];
        if ($days == "0") {
            $json["current"] = $this->model->fetchCurrentWeather($coords);

            return [
                "current" => $json["current"],
            ];
        } elseif ($days == "30") {
            $json["current"] = $this->model->fetchCurrentWeather($coords);
            $json["previous"] = $this->model->fetchPrevWeather($coords, $days);

            return [
                "current" => $json["current"],
                "previous" => $json["previous"],
            ];
        }
    }

    public function welcomeMsg()
    {
        $json = null;

        $json["message"] = "Välkommen till Väder API. Sök på tex. Karlskrona eller Karlskrona, Sverige. Även
        en IP adress går bra tex. 8.8.8.8.<br>";

        return $json;
    }
}
