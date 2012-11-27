<?php

require_once '../Lib/Di/Bootstrap.php';
require_once 'PHPUnit/Autoload.php';

require_once '../Lib/Di/Factory.php';
require_once '../Lib/Di/Dependency.php';
require_once '../_demo/class/Foo.php';

class Bar {};


class DiTests_FactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Factory
     * @access private
     */
    private $_item;
    private $_classname;
    private $_dependencies;


    /**
     * SETUP
     */
    protected function setUp()
    {
        /*

        $this->_instance  = new stdClass();
        $this->_random    = md5(time());
        $this->_array     = array('Foo', 'Bar');
        $this->_string    = 'Foo';
        */

        $this->_classname = 'Foo';
        $this->_item      = new Di_Factory();

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

        $this->_dependencies = array(
            'arguments'    => array('Bar'),
            'constructor'  => null,
            'dependencies' => array(
                $dependency1,
                $dependency2
            )
        );
    }

    public function test_build_noDependencies()
    {
        $this->assertEquals(
            'Bar',
            get_class($this->_item->build('Bar'))
        );
    }

    public function test_build_withDependencies()
    {
        $this->assertEquals(
            $this->_classname,
            get_class($this->_item->build(
                    $this->_classname,
                    $this->_dependencies
                )
            )
        );
    }

    /**
     * @depends test_build_withDependencies
     * @expectedException PHPUnit_Framework_Error
     */
    public function test_build_MissingDependencies()
    {
        $this->assertEquals(
            $this->_classname,
            get_class($this->_item->build($this->_classname))
        );
    }
}

?>
