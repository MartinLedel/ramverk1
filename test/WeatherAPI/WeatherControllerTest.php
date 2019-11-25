<?php
namespace Anax\WeatherAPI;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class WeatherControllerTest extends TestCase
{
    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new WeatherController();
        $controller->setDI($di);
        $controller->initialize();
        // Test the controller action
        $res = $controller->IndexAction();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }

    /**
     * Test the route "index".
     */
    public function testweatherDataAction()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new WeatherController();
        $controller->setDI($di);
        $controller->initialize();
        $request = $di->get("request");
        // Test the controller action
        $request->setGet("searchReq", "Karlskrona");
        $request->setGet("date", "0");
        $res = $controller->weatherDataAction();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }

    /**
     * Test the route "info".
     */
    public function testFetchActionGet()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new WeatherController();
        $controller->setDI($di);
        $controller->initialize();
        $request = $di->get("request");
        // Test the controller action
        $request->setGet("searchReq", "Karlskrona");
        $request->setGet("date", "0");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("searchReq", "8.8.8.8");
        $request->setGet("date", "0");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("searchReq", "8.8.8.8");
        $request->setGet("date", "30");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }

    public function testFetchFailActionGet()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new WeatherController();
        $controller->setDI($di);
        $controller->initialize();
        $request = $di->get("request");
        // Test the controller action
        $request->setGet("searchReq", "");
        $request->setGet("date", "0");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("searchReq", "asdsafasfgafad");
        $request->setGet("date", "0");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("searchReq", "8.8.8.8.8.8.8.8.8.8");
        $request->setGet("date", "0");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("searchReq", "8.8.8.8.8.8.8.8.8.8");
        $request->setGet("date", "30");
        $res = $controller->fetchActionGet();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
}
