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
        $page = $this->di->get("page");
        $session = $this->di->get("session");
        $title = "Validera IP";
        $data = [
        "isValid" => $session->get("isValid"),
        "notValid" => $session->get("notValid"),
        "hostName" => $session->get("hostName"),
        ];

        $session->set("isValid", null);
        $session->set("notValid", null);
        $session->set("hostName", null);

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
        $ip = $this->di->request->getGet("ipValidate");

        if ($this->di->request->getGet("ipV4")) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                $hostname = gethostbyaddr($ip);
                if ($hostname) {
                    $session->set("hostName", $hostname);
                }
                $session->set("isValid", $ip);
            } else {
                $session->set("notValid", $ip);
            }
        }

        if ($this->di->request->getGet("ipV6")) {
            if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                $hostname = gethostbyaddr($ip);
                if ($hostname) {
                    $session->set("hostName", $hostname);
                }
                $session->set("isValid", $ip);
            } else {
                $session->set("notValid", $ip);
            }
        }

        return $this->di->response->redirect("regular");
    }
}
