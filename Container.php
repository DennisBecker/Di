<?php


require_once 'Map.php';
require_once 'Factory.php';
require_once 'Exception.php';


class Di_Container
{
    /**
     * Contains the instance
     *
     * @var object
     * @access protected
     * @static
     */
    private static $_instance = array();
    private $_map;
    private $_bindings = array();
    private $_lastClassname;



    public function __construct($map)
    {
        if (!$this->_map) {
            $this->_map = new Di_Map($map);
        }

        // for chaining
        return $this;
    }


    public function bind(
        $classname,
        $instance  = null,
        $arguments = null,
        $config    = array(
    		'type'     => 'constructor',
            'value'   => null
        )
    ) {
        // store all bindings till call to "->to()"
        if (is_array($classname)) {
            foreach ($classname as $key => $value) {
                $this->_bindings[] = array(
                    $key => $value
                );
            }
        } else {
            $this->_bindings[] = array(
                $classname => array(
                    $instance,
                    $arguments,
                    $config
                )
            );
        }

        // return instance for chaining calls
        return $this;
    }

    public function from(
        $classname,
        $instance  = null,
        $arguments = null,
        $config    = array(
    		'type'     => 'constructor',
            'value'   => null
        )
    ) {
        return $this->bind($classname, $instance, $instance, $config);
    }



    public function to($classname, $arguments = null)
    {
        $this->_map->to($this->_bindings, $classname, $arguments);

        // clear bindings for enabling a second run on the same instance
        unset($this->_bindings);

        // store for chaining
        $this->_lastClassname = $classname;

        // return this for direct chaining ( ->construct() )
        return $this;
    }



    public function construct($classname = null, $arguments = null)
    {
        if (!$classname && !$this->_lastClassname) {
            throw new Di_Exception(
                'Could not complete construct() request! Please provide at least a valid classname.'
            );
        } elseif (!$classname) {
            $classname = $this->_lastClassname;
        }

        // get dependency-map for current classname
        $dependencies = $this->_map->get($classname);

        // remove last classname before call for instance
        unset($this->_lastClassname);

        //
        $factory = new Di_Factory();

        // dispatch to factory
        return $factory->get(
            $classname,
            $arguments,
            $dependencies
        );
    }


    /**
     * instance getter for loose (not including parameter!) singleton
     *
     * This method is intend to setup and call generic singleton-getter and return an instance
     * of the requested class.
     *
     * @return  object instance/object of this class
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public static function getInstance($map = 'default')
    {
        if (!isset(self::$_instance[$map])) {
            self::$_instance[$map] = new self(
                $map
            );
        }

        // return instance
        return self::$_instance[$map];
    }
}


?>