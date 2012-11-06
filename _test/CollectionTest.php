<?php

require_once '../Lib/Di/Bootstrap.php';
require_once 'PHPUnit/Autoload.php';
require_once '../Lib/Di/Collection.php';
require_once '../Lib/Di/Dependency.php';


class DiTests_CollectionTest extends PHPUnit_Framework_TestCase
{
	private $_item;
	private $_dependency;
	private $_classname;
	private $_instance;
	private $_random;
	private $_array;
	private $_string;


    protected function setUp()
    {
		$this->_instance  = new stdClass();
		$this->_initDependencyMock();
		$this->_item      = new Di_Collection();
    	$this->_classname = 'Foo';
		$this->_instance  = new stdClass();
		$this->_random    = md5(time());
		$this->_array     = array('Foo', 'Bar');
		$this->_string    = 'Foo';
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


	public function test_addDependency()
	{
		$this->assertTrue(
			true,
			$this->_item->addDependency($this->_classname, $this->_dependency)
		);
	}

    /**
     * @depends test_addDependency
     * @expectedException PHPUnit_Framework_Error
     */
	public function test_addDependency_WrongType()
	{
		$this->_item->addDependency($this->_classname, $this->_string);
	}

    /**
     * @depends test_addDependency
     */
	public function test_addDependencies()
	{
    	$this->assertTrue(
			true,
			$this->_item->addDependencies(
				$this->_classname,
				array(
					$this->_classname => $this->_dependency,
					$this->_random => $this->_dependency
				)
			)
		);
	}

    /**
     * @depends test_addDependency
     * @expectedException PHPUnit_Framework_Error
     */
	public function test_addDependencies_WrongType()
	{
    	$this->assertTrue(
			true,
			$this->_item->addDependencies(
				$this->_classname,
				array(
					$this->_classname => $this->_dependency,
					$this->_random => $this->_string
				)
			)
		);
	}

	public function test_addArguments()
	{
		$this->_item->addArguments($this->_classname, $this->_array);

		$this->assertEquals(
			$this->_array,
			$this->_item->getArguments($this->_classname)
		);
	}

	/**
	 * @depends test_addArguments
	 */
	public function test_getArguments()
	{
		$this->assertNull(
			$this->_item->getArguments($this->_classname)
		);

		$this->_item->addArguments($this->_classname, $this->_array);

		$this->assertEquals(
			$this->_array,
			$this->_item->getArguments($this->_classname)
		);
	}

	/**
	 * @depends test_addDependency
	 * @depends test_addArguments
	 */
	public function test_getSetup()
	{
		$this->_item->addArguments($this->_classname, $this->_array);
		$this->_item->addDependency($this->_classname, $this->_dependency);

		$setup = $this->_item->getSetup($this->_classname);

		$this->assertArrayHasKey(
			'arguments',
			$this->_item->getSetup($this->_classname)
		);

		$this->assertArrayHasKey(
			'dependencies',
			$this->_item->getSetup($this->_classname)
		);

		$this->assertEquals(
			$setup['arguments'],
			$this->_array
		);

		$this->assertEquals(
			$setup['dependencies'][0],
			$this->_dependency
		);
	}

	public function test_getDependencies()
	{
		$this->assertNull(
			$this->_item->getDependencies($this->_classname)
		);
	}

	/**
	 * @depends test_addDependency
	 */
	public function test_Iterator()
	{
		$count = 0;

		$this->_item->addDependency($this->_classname, $this->_dependency);
		$this->_item->addDependency($this->_random, $this->_dependency);

		foreach ($this->_item as $dependency) {
			$count++;
		}

		$this->assertEquals(
			2,
			$count
		);
	}

    public function test_ArrayAccessOffsetExists()
    {
		$offsets = array(
			'_position',
			'_numericalIndex',
			'_arguments',
			'_indexByTarget',
			'_indexByDependency'
		);

		foreach ($offsets as $offset) {
			$this->assertTrue(
				true,
				isset($this->_item[$offset])
			);
		}
    }

    public function test_ArrayAccessOffsetSet()
    {
		$offsetValueMatrix = array(
			'_position'          => 0,
			'_numericalIndex'    => $this->_array,
			'_arguments'         => $this->_array,
			'_indexByTarget'     => $this->_array,
			'_indexByDependency' => $this->_array
		);

		foreach ($offsetValueMatrix as $offset => $valueToSet) {
			$this->_item[$offset] = $valueToSet;
		}

		foreach ($offsetValueMatrix as $offset => $expectedValue) {
			$this->assertEquals(
				$expectedValue,
				$this->_item[$offset]
			);
		}
    }

    /**
     * @depends test_ArrayAccessOffsetSet
     */
    public function test_ArrayAccessOffsetGet()
    {
		$this->assertFalse(
			false,
			isset($this->_item[$this->_classname])
		);

		$this->_item->addDependency($this->_classname, $this->_dependency);

		$this->assertTrue(
			true,
			isset($this->_item[$this->_classname])
		);
    }

    /**
     * @depends test_ArrayAccessOffsetSet
     */
    public function test_ArrayAccessOffsetUnset()
    {
		$offsetValueMatrix = array(
			'_position'          => 0,
			'_numericalIndex'    => $this->_array,
			'_arguments'         => $this->_array,
			'_indexByTarget'     => $this->_array,
			'_indexByDependency' => $this->_array
		);

		foreach ($offsetValueMatrix as $offset => $valueToSet) {
			$this->_item[$offset] = $valueToSet;
		}

		foreach ($offsetValueMatrix as $offset => $value) {
			unset($this->_item[$offset]);
		}
    }
}

?>
