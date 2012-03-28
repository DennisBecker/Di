<?php


require_once 'Container.php';


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


class Logger
{
    private $_name;
    private $_name2;


    public function __construct($name, $name2)
    {
        $this->_name = $name;
        $this->_name2 = $name2;
    }


    public function getName()
    {
        return $this->_name.$this->_name2;
    }
}


class Persistence
{
    private $_database;
    public  $logger;
    private $_customArgument;


    public function __construct(Database $database, $customArgument)
    {
        $this->_database = $database;
        $this->_customArgument = $customArgument;
    }


    public function setLogger(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function getLogger()
    {
        return $this->logger;
    }


    public function setDatabase(Database $database)
    {
        $this->_database = $database;
    }

    public function getDatabase()
    {
        return $this->_database;
    }
}

class Dummy
{
    private static $_instance;


    private function __construct(Database $database)
    {
        echo 'ol la la :)';
    }

    public static function getInstance(Database $database)
    {
        if (!self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}


// this is an instance of a class
$database = new Database("mysql://user:password@server/database");
$logger = new Logger("Das", "bin ich!");


// get di container (mapname = my_default_map)
$diContainer = Di_Container::getInstance('my_default_map');


$myInstance = $diContainer
            ->bind('Database', $database)
            ->bind('Logger', null, array('Hallo', ' Welt!'), array('type' => 'property', 'value' => 'logger'))
            ->to('Persistence', array('Huhu'))
            ->construct();


var_dump($myInstance);

/*
$diContainer->bind(
    array(
        'D' => $d,
        'C' => $c,
        'B' => $b
    )
)->to();
*/

?>
