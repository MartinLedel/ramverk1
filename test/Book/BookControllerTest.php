<?php
namespace Anax\Book;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;
use Anax\Database\Database;

/**
 * Test the SampleController.
 */
class BookControllerTest extends TestCase
{
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
        $di->get("configuration")->setBaseDirectories([
            ANAX_INSTALL_PATH . "/test/config",
            ANAX_INSTALL_PATH . "/config",
        ]);

        $this->di = $di;
        // Setup the controller
        $this->controllerTest = new BookController();
        $this->controllerTest->setDI($this->di);

        // Setup the db
        $this->db = $this->di->get("dbqb");
        $this->db->connect();

        // Create a temp table
        $sql = <<<EOD
CREATE TABLE Book (
    "id" INTEGER PRIMARY KEY NOT NULL,
    "title" TEXT NOT NULL,
    "author" TEXT NOT NULL,
    "image" TEXT NOT NULL
);
EOD;
        $this->db->execute($sql);

        // Add row to table
        $sql = <<<EOD
INSERT INTO Book (id, title, author, image)
VALUES
    (?, ?, ?, ?)
;
EOD;
        $this->db->execute($sql, $this->rows[0]);
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
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);
    }

    /**
     * Test the route "info".
     */
    public function testCreateAction()
    {
        $request = $this->di->get("request");
        $request->setServer("REQUEST_METHOD", "POST");
        // Test the controller action
        $request->setPost("anax/htmlform-id", "anax/htmlform");
        $request->setPost("Title", "The Lord of the Rings");
        $request->setPost("Author", "J. R. R. Tolkien");
        $request->setPost("Image", "lotr.jpg");
        $request->setPost("submit", "Create book");
        $res = $this->controllerTest->createAction();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Test db
        $sql = "SELECT * FROM Book WHERE id = 1;";
        $res = $this->db->execute($sql);
        $res = $this->db->fetch();
        $this->assertEquals(1, $res->id);
        $this->assertEquals("Metro: Exodus", $res->title);

        $sql = "SELECT * FROM Book WHERE id = 2;";
        $res = $this->db->execute($sql);
        $res = $this->db->fetch();
        $this->assertEquals(2, $res->id);
        $this->assertEquals("The Lord of the Rings", $res->title);
    }

    public function testDeleteAction()
    {
        $request = $this->di->get("request");
        $request->setServer("REQUEST_METHOD", "POST");

        // Test the controller action
        $request->setPost("anax/htmlform-id", "Anax\Book\HTMLForm\DeleteForm");
        $request->setPost("select", "2");
        $request->setPost("submit", "Delete book");
        $res = $this->controllerTest->DeleteAction();
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Test db
        $sql = "SELECT * FROM Book WHERE id = 2;";
        $res = $this->db->execute($sql);
        $res = $this->db->fetch();
        $this->assertEquals(null, $res);
    }

    public function testUpdateAction()
    {
        $request = $this->di->get("request");
        $request->setServer("REQUEST_METHOD", "POST");
        // Test the controller action
        $request->setPost("anax/htmlform-id", "Anax\Book\HTMLForm\UpdateForm");
        $request->setPost("Id", "1");
        $request->setPost("Title", "Metro: Exodus - Redemption");
        $request->setPost("Author", "Dmitry Glukhovsky");
        $request->setPost("Image", "MetroExodus.jpg");
        $request->setPost("submit", "Update book");
        $res = $this->controllerTest->updateAction("1");
        $this->assertInstanceOf("Anax\Response\Response", $res);
        $this->assertInstanceOf("Anax\Response\ResponseUtility", $res);

        // Test db
        $sql = "SELECT * FROM Book WHERE id = 1;";
        $res = $this->db->execute($sql);
        $res = $this->db->fetch();
        $this->assertEquals(1, $res->id);
        $this->assertEquals("Metro: Exodus - Redemption", $res->title);
    }
}
