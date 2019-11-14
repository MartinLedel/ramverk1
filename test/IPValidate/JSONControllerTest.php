<?php
namespace Anax\IPValidate;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class JSONControllerTest extends TestCase
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
        $controller = new JSONController();
        $controller->setDI($di);
        $controller->initialize();
        // Test the controller action
        $res = $controller->IndexAction();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
    /**
     * Test the route "info".
     */
    public function testValidateActionGet()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new JSONController();
        $controller->setDI($di);
        $controller->initialize();
        $request = $di->get("request");
        // Test the controller action
        $request->setGet("ip", "1.160.10.240");
        $request->setGet("kmom", "01");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);

        $request->setGet("ip", "1.160.10.");
        $request->setGet("kmom", "01");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);

        $request->setGet("ip", "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $request->setGet("kmom", "01");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);

        $request->setGet("ip", "2001:0db8:85a3:0000:0000:");
        $request->setGet("kmom", "01");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
    }

    public function test2ValidateActionGet()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        // Use a different cache dir for unit test
        $di->get("cache")->setPath(ANAX_INSTALL_PATH . "/test/cache");
        // Setup the controller
        $controller = new JSONController();
        $controller->setDI($di);
        $controller->initialize();
        $request = $di->get("request");
        // Test the controller action
        $request->setGet("ip", "1.160.10.240");
        $request->setGet("kmom", "02");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("city", $res[0]);

        $request->setGet("ip", "1.160.10.");
        $request->setGet("kmom", "02");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);

        $request->setGet("ip", "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $request->setGet("kmom", "02");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("city", $res[0]);

        $request->setGet("ip", "2001:0db8:85a3:0000:0000:");
        $request->setGet("kmom", "02");
        $res = $controller->validateActionGet();
        $this->assertIsArray($res);
    }
}
