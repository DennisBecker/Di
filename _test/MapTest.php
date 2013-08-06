<?php

///**
// * Bootstrapper of the Di Framework (absolute Path retrieval for Lib)
// */
//require_once '../Lib/Di/Bootstrap.php';
//
///**
// * PHPUnit
// */
//require_once 'PHPUnit/Autoload.php';
//
///**
// * The class we test: Di_Map
// */
//require_once '../Lib/Di/Collection.php';
//require_once '../Lib/Di/Dependency.php';
//require_once '../Lib/Di/Map.php';


class DiTests_MapTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Map
     * @access private
     */
    private $_item;
    private $_classname;
    private $_instance;
    private $_arguments;
    private $_collection;
    private $_random;
    private $_dependency;


    protected function setUp()
    {
        // setup for test
        $this->_classname = 'Foo';
        $this->_instance  = new stdClass();
        $this->_arguments = array('Foo', 'Bar');
        $this->_random    = md5(time());
        $this->_item      = new Di_Map(Di_Map::DEFAULT_NAMESPACE);

        $this->_initDependencyMock();
        $this->_initCollectionMock();
    }

    private function _initDependencyMock()
    {
        $this->_dependency = $this->getMock('\Di_Dependency', null, array($this->_classname));
    }

    private function _initCollectionMock()
    {
        $this->_collection = $this->getMock('\Di_Collection');
        $this->_collection
            ->expects($this->any())
            ->method('addDependency')
            ->with($this->_classname, $this->_dependency)
            ->will($this->returnValue(true));
    }


    public function test_setNamespace()
    {
        $this->_item->setNamespace($this->_random);

        $this->assertEquals(
            $this->_random,
            $this->_item->getNamespace()
        );
    }

    /**
     * @depends test_setNamespace
     */
    public function test_getNamespace()
    {
        $this->assertEquals(
            Di_Map::DEFAULT_NAMESPACE,
            $this->_item->getNamespace()
        );
    }

    public function test_setCollection()
    {
        $this->_item->setCollection($this->_collection);

        $this->assertEquals(
            $this->_collection,
            $this->_item->getCollection()
        );
    }

    /**
     * @depends test_setCollection
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_setCollection_WrongType()
    {
        $this->_item->setCollection(
            $this->_string
        );
    }

    /**
     * @depends test_setCollection
     */
    public function test_getCollection()
    {
        $this->assertNull(
            $this->_item->getCollection()
        );

        $this->_item->setCollection($this->_collection);

        $this->assertEquals(
            $this->_collection,
            $this->_item->getCollection()
        );
    }

    public function test_import()
    {
        $this->_item->import(
            $this->_collection
        );

        $this->assertEquals(
            $this->_collection,
            $this->_item->export()
        );
    }

    /**
     * @depends test_import
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_import_WrongType()
    {
        $this->_item->import(
            $this->_string
        );
    }

    public function test_export()
    {
        $this->assertNull(
            $this->_item->export()
        );

        $this->_item->import(
            $this->_collection
        );

        $this->assertEquals(
            $this->_collection,
            $this->_item->export()
        );
    }

    public function test_wire_Automatic()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->assertTrue(
            true,
            $this->_item->wire(
                Di_Map::WIRE_MODE_AUTOMATIC
            )
        );
    }

    public function test_wire_Manual()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->assertTrue(
            true,
            $this->_item->wire(
                Di_Map::WIRE_MODE_MANUAL,
                array($this->_classname => $this->_instance)
            )
        );
    }

    /**
     * @expectedException Di_Exception
     */
    public function test_wire_Manual_EmptyMap()
    {
        $this->_item->setCollection(
            $this->_collection
        );

        $this->assertTrue(
            true,
            $this->_item->wire(
                Di_Map::WIRE_MODE_MANUAL
            )
        );
    }
}

?>
