<?php

require_once '../Lib/Di/Bootstrap.php';
require_once 'PHPUnit/Autoload.php';
require_once '../Lib/Di/Dependency.php';


class DiTests_DependencyTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Dependency
     * @access private
     */
    private $_item;
    private $_classname;
    private $_instance;
	private $_random;

	private $_array;
	private $_string;


	/**
	 * SETUP
	 */
    protected function setUp()
    {
    	$this->_classname = 'Foo';
		$this->_instance  = new stdClass();
		$this->_random    = md5(time());

		$this->_array     = array('Foo', 'Bar');
		$this->_string    = 'Foo';

		$this->_item      = new Di_Dependency($this->_classname);
    }

	/**
	 * TESTS
	 */
    public function test_initClass()
    {
		$this->assertEquals(
			$this->_classname,
			$this->_item->getClassname()
		);

		$this->assertEquals(
			$this->_classname,
			$this->_item->__toString()
		);
    }

    /**
     * @depends test_initClass
     */
    public function test_setClassname()
    {
		$this->assertTrue(
			true,
			$this->_item->setClassname($this->_classname)
		);
    }

    /**
     * @depends test_setClassname
     */
    public function test_getClassname()
    {
		$this->assertEquals(
    		$this->_classname,
    		$this->_item->getClassname()
    	);

    	$this->_item->setClassname($this->_random);

		$this->assertEquals(
			$this->_random,
			$this->_item->getClassname()
		);
    }

    public function test_setInstance()
    {
    	$this->assertTrue(
			true,
    		$this->_item->setInstance($this->_instance)
    	);
    }

    /**
     * @depends test_setInstance
     */
    public function test_getInstance()
    {
		$this->assertNull(
    		$this->_item->getInstance()
    	);

    	$this->_item->setInstance($this->_instance);

    	$this->assertEquals(
			$this->_instance,
    		$this->_item->getInstance()
    	);
    }

    public function test_setIdentifier()
    {
    	$this->assertTrue(
			true,
    		$this->_item->setIdentifier($this->_random)
    	);
    }

    /**
     * @depends test_setIdentifier
     */
    public function test_getIdentifier()
    {
		$this->assertNull(
    		$this->_item->getIdentifier()
    	);

    	$this->_item->setIdentifier($this->_random);

    	$this->assertEquals(
			$this->_random,
    		$this->_item->getIdentifier()
    	);
    }


    public function test_setArguments()
    {
    	$this->assertTrue(
			true,
    		$this->_item->setArguments($this->_array)
    	);
    }

    /**
     * @depends test_setArguments
     */
    public function test_getArguments()
    {
		$this->assertNull(
    		$this->_item->getArguments()
    	);

    	$this->_item->setArguments($this->_array);

    	$this->assertEquals(
			$this->_array,
    		$this->_item->getArguments()
    	);
    }

    /**
     * @depends test_setArguments
     */
    public function test_hasArguments()
    {
		$this->assertFalse(
    		false,
    		$this->_item->hasArguments()
    	);

    	$this->_item->setArguments($this->_array);

		$this->assertTrue(
    		true,
    		$this->_item->hasArguments()
    	);
    }

    /**
     * @depends test_setArguments
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_setArgumentsInvalidType()
    {
    	$this->_item->setArguments($this->_string);
    }


    public function test_setConfiguration()
    {
    	$this->assertTrue(
			true,
    		$this->_item->setConfiguration($this->_array)
    	);
    }

    /**
     * @depends test_setConfiguration
     */
    public function test_getConfiguration()
    {
		$this->assertCount(
			1,
			$this->_item->getConfiguration()
		);

		$this->assertEquals(
			array('type' => Di_Dependency::TYPE_CONSTRUCTOR),
			$this->_item->getConfiguration()
		);

    	$this->_item->setConfiguration($this->_array);

    	$this->assertEquals(
			$this->_array,
    		$this->_item->getConfiguration()
    	);
    }

    /**
     * @depends test_setConfiguration
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_setConfigurationInvalidType()
    {
    	$this->_item->setConfiguration($this->_string);
    }

    /**
     * @depends test_setClassname
     * @depends test_setInstance
     * @depends test_setArguments
     * @depends test_setConfiguration
     */
    public function test_asArray()
    {
		$this->assertNotEmpty(
			$this->_item->asArray()
		);

		$this->assertArrayHasKey(
    		'classname',
    		$this->_item->asArray()
    	);

		$this->assertArrayHasKey(
    		'instance',
    		$this->_item->asArray()
    	);

		$this->assertArrayHasKey(
    		'arguments',
    		$this->_item->asArray()
    	);

		$this->assertArrayHasKey(
    		'configuration',
    		$this->_item->asArray()
    	);

		$this->assertArrayNotHasKey(
    		'foo',
    		$this->_item->asArray()
    	);

    	$this->_item->setClassname($this->_classname);
		$this->_item->setInstance($this->_instance);
    	$this->_item->setArguments($this->_array);
    	$this->_item->setConfiguration($this->_array);

    	$result = $this->_item->asArray();

    	$this->assertEquals(
			$result['classname'],
			$this->_classname
    	);

    	$this->assertEquals(
			$result['instance'],
			$this->_instance
    	);

    	$this->assertEquals(
			$result['arguments'],
			$this->_array
    	);

    	$this->assertEquals(
			$result['configuration'],
			$this->_array
    	);
    }

    public function test_getRandomId()
    {
    	$id1 = $this->_item->getRandomId();
    	$id2 = $this->_item->getRandomId();

		$this->assertNotEquals(
			$id1,
			$id2
		);
    }


    public function test_ArrayAccessOffsetExists()
    {
		$offsets = array(
			'_classname',
			'_instance',
			'_arguments',
			'_configuration',
			'_identifier'
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
			'_classname'     => $this->_classname,
			'_instance'      => $this->_instance,
			'_arguments'     => $this->_array,
			'_configuration' => $this->_array,
			'_identifier'    => $this->_classname
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
		$offsetValueMatrix = array(
			'_classname'     => $this->_classname,
			'_instance'      => null,
			'_arguments'     => null,
			'_configuration' => null,
			'_identifier'    => null
		);

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
    public function test_ArrayAccessOffsetUnset()
    {
		$offsetValueMatrix = array(
			'_classname'     => $this->_classname,
			'_instance'      => $this->_instance,
			'_arguments'     => $this->_array,
			'_configuration' => $this->_array,
			'_identifier'    => $this->_classname
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
