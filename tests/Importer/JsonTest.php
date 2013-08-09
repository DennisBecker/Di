<?php

//require_once '../lib/Di/Bootstrap.php';
//require_once 'PHPUnit/Autoload.php';
//
//require_once '../lib/Di/Importer/Json.php';


class DiTests_Importer_JsonTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Importer_Json
     * @access private
     */
    private $_item;
    private $_invalidSource;
    private $_validSource;
    private $_collection;
    private $_random;


    protected function setUp()
    {
        $this->_collection    = new Di_Collection();
        $this->_item          = new Di_Importer_Json();
        $this->_validSource   = __DIR__ . '/../_data/map1.json';
        $this->_invalidSource = __DIR__ . '/../_data/map2.json';
        $this->_random        = md5(time());
    }

    public function test_getCollection()
    {
        $this->assertNull(
            $this->_item->getCollection()
        );
    }

    /**
     * @depends test_getCollection
     */
    public function test_export()
    {
        $this->assertNull(
            $this->_item->export()
        );
    }

    /**
     * @depends test_getCollection
     */
    public function test_setCollection()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->assertEquals(
            $this->_collection,
            $this->_item->getCollection()
        );
    }

    /**
     * @depends test_setCollection
     */
    public function test_import()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->_item->setInput($this->_validSource);

        $this->assertTrue(
            true,
            $this->_item->import()
        );
    }

    /**
     * @depends test_import
     * @expectedException Di_Exception
     */
    public function test_import_noCollection()
    {
        $this->_item->import($this->_validSource);
    }

    /**
     * @depends test_import
     * @expectedException Di_Exception
     */
    public function test_import_invalidSource()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->_item->setInput($this->_random);

        $this->_item->import();
    }

    /**
     * @depends test_import
     * @expectedException Di_Exception
     */
    public function test_import_invalidJson()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->_item->setInput($this->_invalidSource);

        $this->_item->import();
    }
}

?>
