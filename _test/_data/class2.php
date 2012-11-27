<?php

/**
 * @DiInject new:Class force:true constructor:1
 */
class Foo
{
    private $_database;
    private $_customArgument;
    private $_timestamp;
    public  $Logger1;

    /**
     * @DiInject DependencyName Foo
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
