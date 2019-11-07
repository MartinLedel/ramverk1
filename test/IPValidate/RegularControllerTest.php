<?php
namespace Anax\IPValidate;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class RegularControllerTest extends TestCase
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
        $controller = new RegularController();
        $controller->setDI($di);
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
        $controller = new RegularController();
        $controller->setDI($di);
        $request = $di->get("request");
        $response = $di->get("response");
        // Test the controller action
        $request->setGet("ipValidate", "1.160.10.240");
        $request->setGet("ipVersion", "ipV4");
        $res = $controller->validateActionGet();
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("ipValidate", "1.160.10");
        $request->setGet("ipVersion", "ipV4");
        $res = $controller->validateActionGet();
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("ipValidate", "2001:0db8:85a3:0000:0000:8a2e:0370:7334");
        $request->setGet("ipVersion", "ipV6");
        $res = $controller->validateActionGet();
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        $request->setGet("ipValidate", "2001:0db8:85a3:0000:0000:");
        $request->setGet("ipVersion", "ipV6");
        $res = $controller->validateActionGet();
        $response->redirectSelf();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }
}
