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
class WeatherController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    public $model;

    public function initialize()
    {
        $this->model = new WeatherModel();
    }
    /**
     * Route for index view and form
     *
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $weather = $this->di->get("weather");
        $message = $weather->welcomeMsg();
        $title = "Väder API";;
        $data = [
        "message" => $message["message"],
        ];

        $page->add("weatherapi/weather", $data);

        return $page->render([
         "title" => $title,
        ]);
    }
    public function weatherDataAction() : object
    {
        $request = $this->di->get("request");
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $weather = $this->di->get("weather");
        $message = $weather->welcomeMsg();
        $title = "Väder API";
        $data = [
        "message" => $message["message"],
        "jsonData" => $session->get("jsonData"),
        "address" => $session->get("address")
        ];

        $session->set("jsonData", null);
        $session->set("address", null);

        $page->add("weatherapi/weather-data", $data);

        return $page->render([
         "title" => $title,
        ]);
    }
    /**
     * Route for form POST
     *
     */
    public function fetchActionGet() : object
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");
        $response = $this->di->get("response");

        $searchReq = $request->getGet("searchReq") ?? "";
        $date = $request->getGet("date");

        $this->model->getWeatherData($session, $searchReq, $date);

        return $response->redirect("weather-api/weather-data");
    }
}
