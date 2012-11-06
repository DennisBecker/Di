<?php 

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

?>
