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
    * @var string $db a sample member variable that gets initialised
    */
    //private $db = "not active";
    public function indexAction() : object
    {
        $page = $this->di->get("page");
        $title = "Validera IP";

        $page->add("ipvalidate/json");

        return $page->render([
         "title" => $title,
        ]);
    }
    /**
     * Route for form POST
     *
     */
    public function validateActionGet() : array
    {
        $ip = $this->di->request->getGet("ipValidate");
        $json = [];

        if ($this->di->request->getGet("ipVersion") == "ipV4") {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $hostname = gethostbyaddr($ip);
                if ($hostname) {
                    $json["hostName"] = $hostname;
                }
                $json["ipValidate"] = $ip;
                $json["message"] = "Validated.";
            } else {
                $json["ipValidate"] = $ip;
                $json["message"] = "Did not validate.";
            }
        } elseif ($this->di->request->getGet("ipVersion") == "ipV6") {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $hostname = gethostbyaddr($ip);
                if ($hostname) {
                    $json["hostName"] = $hostname;
                }
                $json["ipValidate"] = $ip;
                $json["message"] = "Validated.";
            } else {
                $json["ipValidate"] = $ip;
                $json["message"] = "Did not validate.";
            }
        }

        return [$json];
    }
}
