<?php

/**
 * @DiInject Database:Database1 constructor position:1
 */
class Foo1
{
    private $_database;
    private $_customArgument;
    private $_timestamp;

    /**
     * @DiInject Logger:Logger1 type:property value:logger
     */
    public  $Logger1;

    /**
     * @DiInject Database:Database1 constructor position:1
     */
    public function __construct(Database $Database1, $customArgument)
    {
        $this->_database       = $Database1;
        $this->_customArgument = $customArgument;
        $this->_timestamp      = microtime();
    }


    public function setLogger(Logger $Logger1)
    {
        $this->Logger1 = $Logger1;
    }

    public function getLogger()
    {
        return $this->Logger1;
    }


    public function setDatabase(Database $Database1)
    {
        $this->_database = $Database1;
    }

    public function getDatabase()
    {
        return $this->_database;
    }


    public function test()
    {
        echo 'Hello World!';
    }
}

?>
