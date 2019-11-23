<?php

namespace Anax\WeatherAPI;

use Anax\Commons\ContainerInjectableInterface;
use Anax\Commons\ContainerInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WeatherJSONController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;

    public function initialize()
    {
        $this->model = new weatherModel();
    }
    /**
     * JSON form
     *
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $weather = $this->di->get("weather");
        $message = $weather->welcomeMsg();
        $title = "Väder API";;
        $data = [
        "message" => $message["message"],
        ];

        $page->add("weatherapi/weather-json", $data);

        return $page->render([
         "title" => $title,
        ]);
    }
    /**
     * JSON API
     *
     */
    public function fetchActionGet() : array
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");

        $searchReq = $request->getGet("searchReq") ?? "";
        $date = $request->getGet("date");

        $this->model->getWeatherData($session, $searchReq, $date);
        $json = [
            "address" => $session->get("address"),
            "weather_data" => $session->get("jsonData")
        ];

        $session->set("jsonData", null);
        $session->set("address", null);

        return [$json];
    }
}
