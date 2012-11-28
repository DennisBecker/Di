<?php

require_once '../Lib/Di/Bootstrap.php';
require_once 'PHPUnit/Autoload.php';

require_once '../Lib/Di/Parser/Annotation.php';


class DiTests_Parser_AnnotationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Instance of the class to test
     *
     * @var Di_Parser_Annnotation
     * @access private
     */
    private $_item;
    private $_validInput;
    private $_invalidInput;


    protected function setUp()
    {
        /* @var $this->_item Di_Parser_Annotation */
        $this->_item         = new Di_Parser_Annotation();
        $this->_validInput   = file_get_contents('_data/class.php');
        $this->_invalidInput = array('Hello', 'World');
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
            $this->_validInput
        );
    }

    /**
     * @depends test_getInput
     */
    public function test_getInput_withInput()
    {
        $this->_item->setInput(
            $this->_validInput
        );

        $this->assertEquals(
            $this->_validInput,
            $this->_item->getInput()
        );
    }


    /**
     * @depends test_setInput
     */
    public function test_reset()
    {
        $this->_item->setInput(
            $this->_validInput
        );

        $this->_item->reset();

        $this->assertNull(
            $this->_item->getInput()
        );
    }

    /**
     * @depends test_setInput
     */
    public function test_parse()
    {
        $this->_item->setInput(
            array(
                'class' => 'Foo1',
                'file'  => '_data/class.php'
            )
        );

        $this->assertInternalType(
            'array',
            $this->_item->parse()
        );

        $this->assertNotEmpty(
            $this->_item->parse()
        );

        $keys = array(
            'class',
            'identifier',
            'instance',
            'type',
            'value',
            'position'
        );

        $testAgainst = $this->_item->parse();

        foreach ($keys as $key) {
            $this->assertArrayHasKey(
                $key,
                $testAgainst[0]
            );
        }
    }

    /**
     * @depends test_setInput
     * @expectedException Di_Exception
     */
    public function test_parse_noInput()
    {
        $this->_item->parse();
    }

    public function test_hasCommand()
    {
        $this->assertFalse(
            $this->_item->hasCommand()
        );

        $this->_item->setInput(
            array(
                'class' => 'Foo1',
                'file'  => '_data/class.php'
            )
        )->parse();

        $this->assertTrue(
            $this->_item->hasCommand()
        );
    }

    public function test_numberOfCommands()
    {
        $this->assertEquals(
            0,
            $this->_item->numberOfCommands()
        );

        $this->_item->setInput(
            array(
                'class' => 'Foo1',
                'file'  => '_data/class.php'
            )
        )->parse();

        $this->assertEquals(
            3,
            $this->_item->numberOfCommands()
        );
    }
}

?>