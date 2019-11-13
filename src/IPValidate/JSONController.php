<?php

namespace Anax\IPValidate;

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
class JSONController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;

    /**
     * JSON form
     *
     */
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $title = "Validera IP";
        $userIP = file_get_contents("http://ipecho.net/plain");
        $data = [
        "userIP" => $userIP,
        ];

        $page->add("ipvalidate/json", $data);

        return $page->render([
         "title" => $title,
        ]);
    }
    /**
     * JSON API
     *
     */
    public function validateActionGet() : array
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $kmom01model = new kmom01Model();
        $kmom02model = new kmom02Model();

        $ip = $request->getGet("ip");

        if ($request->getGet("kmom") == "01") {
            $json = $kmom01model->jsonValidateKmom01($ip);
        } elseif ($request->getGet("kmom") == "02") {
            $json = $kmom02model->getDataKmom02($ip);
        }

        return [$json];
    }
}
