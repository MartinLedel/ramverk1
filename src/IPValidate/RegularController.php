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
class RegularController implements ContainerInjectableInterface
{
    use ContainerInjectableTrait;
    /**
     * Route for index view and form
     *
     */
    public function indexAction() : object
    {
        $request = $this->di->get("request");
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $title = "Validera IP";
        $userIP = file_get_contents("http://ipecho.net/plain");
        $data = [
        "userIP" => $userIP,
        "validatedText" => $session->get("validatedText"),
        "jsonData" => $session->get("jsonData"),
        ];

        $session->set("validatedText", null);
        $session->set("jsonData", null);

        $page->add("ipvalidate/regular", $data);

        return $page->render([
         "title" => $title,
        ]);
    }
    /**
     * Route for form POST
     *
     */
    public function validateActionGet() : object
    {
        $session = $this->di->get("session");
        $request = $this->di->get("request");
        $response = $this->di->get("response");
        $kmom01model = new kmom01Model();
        $kmom02model = new kmom02Model();

        $ip = $request->getGet("ip");

        if ($request->getGet("kmom") == "01") {
            $validatedText = $kmom01model->regularValidateKmom01($ip);
            $session->set("validatedText", $validatedText);
        } elseif ($request->getGet("kmom") == "02") {
            $json = $kmom02model->getDataKmom02($ip);
            $session->set("jsonData", $json);
        }

        return $response->redirect("regular");
    }
}
