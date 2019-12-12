<?php
namespace Anax\Book;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the SampleController.
 */
class BookControllerTest extends TestCase
{
    private $sqliteOptions = [
        "dsn" => "sqlite:memory::",
        "verbose" => false
    ];
    private $rows = [
        [1, "Metro: Exodus", "Dmitry Glukhovsky", "MetroExodus.jpg"],
        [2, "LOTR", "J.R.R Tolkien", "lotr.jpg"],
        [3, "Leviathan Wakes", "James S. A. Corey", "lw.jpg"],
    ];
    private $db;
    protected $controllerTest;

    /**
     * Setup before each testcase
     */
    protected function setUp()
    {
        global $di;
        // Setup di
        $di = new DIFactoryConfig();
        $di->loadServices(ANAX_INSTALL_PATH . "/config/di");

        $this->di = $di;
        // Setup the controller
        $this->controllerTest = new BookController();
        $this->controllerTest->setDI($this->di);

        // Setup the db
        $this->db = new Database();
        $this->db->setOptions($this->sqliteOptions);
        $this->db->connect();
    }

    /**
     * Tear down after each testcase
     */
    protected function tearDown()
    {
        $this->di->get("session")->destroy();
    }

    /**
     * Test the route "index".
     */
    public function testIndexActionGet()
    {
        // Test the controller action
        $res = $this->controllerTest->indexActionGet();
        var_dump($res);
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }

    /**
     * Test the route "info".
     */
    // public function testCreateActionGet()
    // {
    //     $request = $di->get("request");
    //     // Test the controller action
    //     $request->setGet("ip", "1.160.10.240");
    //     $request->setGet("kmom", "01");
    //     $res = $controllerTest->createActionGet();
    //     $this->assertInstanceOf("Anax\Response\Response", $res);
    //     $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    // }
    //
    // public function testDeleteActionGet()
    // {
    //     $request = $di->get("request");
    //     // Test the controller action
    //     $request->setGet("ip", "1.160.10.240");
    //     $request->setGet("kmom", "02");
    //     $res = $controllerTest->DeleteActionGet();
    //     $this->assertInstanceOf("Anax\Response\Response", $res);
    //     $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    // }
    //
    // public function testUpdateActionGet()
    // {
    //     $request = $di->get("request");
    //     // Test the controller action
    //     $request->setGet("ip", "1.160.10.240");
    //     $request->setGet("kmom", "02");
    //     $res = $controllerTest->updateActionGet();
    //     $this->assertInstanceOf("Anax\Response\Response", $res);
    //     $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    // }
}
