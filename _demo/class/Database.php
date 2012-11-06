<?php 

class Database
{
    private $_connection;


    public function __construct($connection)
    {
        $this->_connection = $connection;
    }


    public function getConnection()
    {
        return $this->_connection;
    }
}

?>
