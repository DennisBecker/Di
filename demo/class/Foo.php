<?php

class Foo
{
    private $_database;
    private $_customArgument;
    private $_timestamp;

    /**
     * @DiInject Logger:Logger1 type:property value:logger
     */
    public $logger;

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
        $this->logger = $Logger1;
    }

    public function getLogger()
    {
        return $this->logger;
    }


    public function setDatabase(Database $Database1)
    {
        $this->_database = $Database1;
    }

    public function getDatabase()
    {
        return $this->_database;
    }


    public function test(array $test = array())
    {
        echo 'Hello World!';
    }
}

?>
