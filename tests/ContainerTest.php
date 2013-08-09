<?php

//require_once '../lib/Di/Bootstrap.php';
//require_once 'PHPUnit/Autoload.php';
//
//require_once '../lib/Di/Dependency.php';
//require_once '../lib/Di/Collection.php';
//require_once '../lib/Di/Map.php';
//require_once '../lib/Di/Factory.php';
//require_once '../lib/Di/Container.php';
require_once __DIR__ . '/../demo/class/Foo.php';


class DiTests_ContainerTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Container
     * @access private
     */
    private $_item;
    private $_classname;
    private $_instance;
    private $_arguments;
    private $_collection;
    private $_dependency;
    private $_random;
    private $_map;


    protected function setUp()
    {
        // setup for test
        $this->_classname = 'Foo';
        $this->_instance  = new stdClass();
        $this->_arguments = array('Foo', 'Bar');
        $this->_random    = md5(time());
        $this->_item      = Di_Container::getInstance($this->_random);

        $this->_initDependencyMock();
        $this->_initCollectionMock();
        $this->_initMapMock();
    }

    private function _initDependencyMock()
    {
        $this->_dependency = $this->getMock('\Di_Dependency', null, array('Bar'));
        $this->_dependency
            ->expects($this->any())
            ->method('getClassname')
            ->will($this->returnValue('Bar'));

        $this->_dependency
            ->expects($this->any())
            ->method('getIdentifier')
            ->will($this->returnValue('Bar'));

        $this->_dependency
            ->expects($this->any())
            ->method('getInstance')
            ->will($this->returnValue($this->_instance));
    }

    private function _initCollectionMock()
    {
        $this->_collection = $this->getMock('\Di_Collection');
        $this->_collection
            ->expects($this->any())
            ->method('addDependency')
            ->with($this->_classname, $this->_dependency)
            ->will($this->returnValue(true));

        $this->_collection
            ->expects($this->any())
            ->method('getSetup')
            ->with($this->_classname)
            ->will($this->returnValue('HALLO'));

        $this->_collection
            ->expects($this->any())
            ->method('getMap')
            ->with($this->_classname)
            ->will($this->returnValue($this->_map));
    }

    private function _initMapMock()
    {
        $this->_map = $this->getMock('\Di_Map');

        $this->_map
            ->expects($this->any())
            ->method('setCollection')
            ->with($this->_classname, $this->_dependency)
            ->will($this->returnValue(true));

        $this->_map
            ->expects($this->any())
            ->method('getCollection')
            ->will($this->returnValue(array('ALOHA')));

        $this->_map
            ->expects($this->any())
            ->method('export')
            ->will($this->returnValue($this->_collection));
    }

    public function test_getMap_Null()
    {
        $this->assertNull(
            $this->_item->getMap()
        );
    }

    public function test_setMap_NoOverride()
    {
        $this->assertTrue(
            true,
            $this->_item->setMap($this->_map, false)
        );
    }

    public function test_setMap_twiceAndMerge()
    {
        $this->_item->setMap($this->_map, false);

        $this->assertTrue(
            true,
            $this->_item->setMap($this->_map, false)
        );
    }

    public function test_setMap()
    {
        $this->assertTrue(
            true,
            $this->_item->setMap($this->_map)
        );
    }

    public function test_getMap()
    {
        $this->assertEquals(
            $this->_map,
            $this->_item->getMap()
        );
    }

    public function test_importMapFromOtherNamespace()
    {
        $this->_item->importMapFromOtherNamespace($this->_random);

        $this->assertEquals(
            $this->_map,
            $this->_item->getMapFromOtherNamespace($this->_random)
        );
    }

    public function test_getMapFromOtherNamespace()
    {
        $this->assertEquals(
            $this->_map,
            $this->_item->getMapFromOtherNamespace($this->_random)
        );
    }

    /**
     * @expectedException Di_Exception
     */
    public function test_getMapFromOtherNamespace_NotExists()
    {
        $this->assertEquals(
            $this->_map,
            $this->_item->getMapFromOtherNamespace($this->_random.$this->_random)
        );
    }

    public function test_build()
    {
        $map = new Di_Map();
        $collection = new Di_Collection();

        $Database1 = $this->getMock('\Database');
        $Logger1   = $this->getMock('\Logger');

        $dependency1 = new Di_Dependency('Database');
        $dependency1->setIdentifier('Database1');
        $dependency1->setInstance($Database1);
        $dependency2 = new Di_Dependency('Logger');
        $dependency2->setIdentifier('Logger1');
        $dependency2->setInstance($Logger1);
        $dependency2->setConfiguration(
            array(
                'type'  => Di_Dependency::TYPE_METHOD,
                'value' => 'setLogger'
            )
        );
        $factory = new Di_Factory();

        $collection->addDependency($this->_classname, $dependency1);
        $collection->addDependency($this->_classname, $dependency2);
        $collection->addArguments($this->_classname, array('Bar'));

        $map->setCollection($collection);

        $this->_item->setMap($map);
        $this->_item->setFactory($factory);

        // the test
        $this->assertEquals(
            $this->_classname,
            get_class($this->_item->build($this->_classname))
        );
    }

    /**
     * @expectedException Di_Exception
     */
    public function test_build_noMap()
    {
        $this->_item->getMap()->reset();
        $this->_item->build($this->_classname);
    }
}

?>
