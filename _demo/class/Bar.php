<?php

class Bar
{
	static private $_instance;

	private $_database;

	/**
     * @DiInject Logger:Logger1 type:property value:Logger1
     */
	private $Logger1;


	private function __construct(Database $Database1, Logger $Logger1)
	{
		$this->_database = $Database1;
		$this->Logger1    = $Logger1;
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


	private function __clone()
	{
		// protected access
	}

    /**
     * @DiInject Database:Database1 constructor position:1
     * @DiInject Logger:Logger1 constructor position:2
     */
	static public function getInstance(Database $Database1, Logger $Logger1)
	{
		if (!self::$_instance) {
			self::$_instance = new self($Database1, $Logger1);
		}

		return self::$_instance;
	}
}

?>
