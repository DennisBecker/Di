<?php

//require_once '../lib/Di/Bootstrap.php';
//require_once 'PHPUnit/Autoload.php';
//
//require_once '../lib/Di/Parser/Constructor.php';

class Bar1
{
    private function __construct(){}

    public static function getInstance()
    {
        return new self();
    }
};

class Bar2
{
    private function __construct(){}

    public static function getInstance()
    {
        return new Bar2();
    }
};

class DiTests_Parser_ConstructorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Parser_Constructor
     * @access private
     */
    private $_item;
    private $_inputSet1;
    private $_inputSet2;
    private $_inputSet3;
    private $_inputSet4;
    private $_inputSet5;
    private $_invalidInput;


    protected function setUp()
    {
        $this->_item            = new Di_Parser_Constructor();
        $this->_inputSet1       = array('class' => 'Foo1', 'file' => __DIR__ . '/../_data/class.php', 'reflection' => false);
        $this->_inputSet2       = array('class' => 'Foo1', 'file' => __DIR__ . '/../_data/class.', 'reflection' => false);
        $this->_inputSet3       = array('class' => 'Fo', 'reflection' => false);
        $this->_inputSet4       = array('class' => 'Bar1');
        $this->_inputSet5       = 'Bar1';
        $this->_inputSet6       = array('class' => 'Bar2');
        $this->_incompleteInput = array('class' => 'Foo1');
        $this->_invalidInput    = array();
    }


    public function test_getInput()
    {
        $this->assertNull(
            $this->_item->getInput()
        );
    }

    /**
     * @depends test_getInput
     */
    public function test_setInput()
    {
        $this->_item->setInput(
            $this->_inputSet1
        );

        $this->assertEquals(
            $this->_inputSet1,
            $this->_item->getInput()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_reset()
    {
        $this->_item->setInput(
            $this->_inputSet1
        );

        $this->_item->reset();

        $this->assertNull(
            $this->_item->getInput()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_parse_set1()
    {
        $this->_item->setInput(
            $this->_inputSet1
        );

        $this->assertEquals(
            '__construct',
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     * @expectedException Di_Exception
     */
    public function test_parse_set2()
    {
        $this->_item->setInput(
            $this->_inputSet2
        );

        $this->assertNull(
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     * @expectedException Di_Exception
     */
    public function test_parse_set3()
    {
        $this->_item->setInput(
            $this->_inputSet3
        );

        $this->assertNull(
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_parse_set4()
    {
        $this->_item->setInput(
            $this->_inputSet4
        );

        $this->assertEquals(
            'getInstance',
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_parse_set5()
    {
        $this->_item->setInput(
            $this->_inputSet5
        );

        $this->assertEquals(
            'getInstance',
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_parse_set6()
    {
        $this->_item->setInput(
            $this->_inputSet6
        );

        $this->assertEquals(
            'getInstance',
            $this->_item->parse()
        );
    }

    /**
     * @depends test_setInput
     * @expectedException Di_Exception
     */
    public function test_parse_invalid()
    {
        $this->_item->setInput(
            $this->_invalidInput
        );

        $this->assertNull(
            $this->_item->parse()
        );
    }
}

?>
