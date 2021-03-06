<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Container
 *
 * Container.php - Container class of the Di-Framework
 *
 * PHP versions 5
 *
 * LICENSE:
 * Di - The Dependency Injection Framework
 *
 * Copyright (c) 2012, Benjamin Carl - All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 * - All advertising materials mentioning features or use of this software
 *   must display the following acknowledgement: This product includes software
 *   developed by Benjamin Carl and other contributors.
 * - Neither the name Benjamin Carl nor the names of other contributors
 *   may be used to endorse or promote products derived from this
 *   software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * Please feel free to contact us via e-mail: opensource@clickalicious.de
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Container
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */

//require_once DI_PATH_LIB_DI.'Map.php';
//require_once DI_PATH_LIB_DI.'Dependency.php';
//require_once DI_PATH_LIB_DI.'Factory.php';
//require_once DI_PATH_LIB_DI.'Exception.php';

/**
 * Di Container
 *
 * Container class of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Container
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Container
{
    /**
     * Contains container instances
     *
     * @var object
     * @access protected
     * @static
     */
    private static $_instances = array();

    /**
     * The namespace of this container instance
     *
     * @var string
     * @access private
     */
    private $_namespace;

    /**
     * The mode the instance operates in
     *
     * @var integer
     * @access private
     */
    private $_mode;

    /**
     * Contains the dependency maps of all containers
     *
     * @var array
     * @access private
     * @static
     */
    static private $_dependencyMaps = array();

    /**
     * Instance of Di_Factory for creating instances
     *
     * @var Di_Factory
     * @access private
     */
    private $_factory;

    /**
     * Default namespace
     *
     * @var string
     * @access public
     */
    const DEFAULT_NAMESPACE   = 'Di';

    /**
     * The mode used to handle maps
     * This can be either
     * STATIC  = Used for static
     * DYNAMIC = Used for dynamic creation of instances
     *
     * @var integer
     * @access public
     */
    const MODE_STATIC  = 1;
    const MODE_DYNAMIC = 2;


    /*******************************************************************************************************************
     * PUBLIC API
     ******************************************************************************************************************/

    /**
     * Adds a Di_Map to an existing Map by merging it in
     *
     * This method is intend to merge a new Di_Map with an existing one.
     *
     * @param Di_Map  $map      The map to merge in
     * @param boolean $override TRUE to override the existing map, FALSE to merge the maps
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setMap(Di_Map $map, $override = true)
    {
        if ($override === false) {
            $existingMap = $this->getMap();

            if ($existingMap) {
                $map = $this->_mergeMaps($existingMap, $map);
            }
        }

        // store
        self::$_dependencyMaps[$this->_namespace] = $map;

        // success
        return true;
    }

    /**
     * Returns the dependency map of this container
     *
     * This method is intend to return the dependency map instance of this
     * container instance.
     *
     * @return  Di_Map The dependency map instance as Di_Map if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getMap()
    {
        return (isset(self::$_dependencyMaps[$this->_namespace]))
            ? self::$_dependencyMaps[$this->_namespace]
            : null;
    }

    /**
     * Returns the Dependency-Map from another namespace
     *
     * This method is intend to return the Dependency-Map of another namespace.
     *
     * @param string $namespace The namespace to load map from
     *
     * @return  Di_Map The dependency instance from another namespace
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     */
    public function getMapFromOtherNamespace($namespace)
    {
        if (!isset(self::$_dependencyMaps[$namespace])) {
            throw new Di_Exception(
                'Dependency-Map could not be found. Dependency-Map with namespace "'.$namespace.'" does not exist.'
            );
        }

        // return requested map
        return self::$_dependencyMaps[$namespace];
    }

    /**
     * Imports a Dependency-Map from another namespace
     *
     * This method is intend to import a Dependency-Map from another namespace.
     *
     * @param string $namespace The namespace to load dependency map from
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function importMapFromOtherNamespace($namespace)
    {
        self::$_dependencyMaps[$this->_namespace] = $this->getMapFromOtherNamespace($namespace);
    }

    /**
     * Setter for Factory
     *
     * This method is intend to set the instance of Di_Factory
     *
     * @param Di_Factory $factory The factory instance to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setFactory(Di_Factory $factory)
    {
        $this->_factory = $factory;
    }

    /**
     * Getter for Factory
     *
     * This method is intend to return the instance of Di_Factory
     *
     * @return  mixed The instance of Di_Factory if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getFactory()
    {
        return $this->_factory;
    }

    /**
     * Constructs all single parts and returns a new instance
     *
     * This method is intend to combine all defined dependencies and returns a
     * instance of requested class.
     *
     * @param string $classname The name of the class to build
     * @param mixed  $arguments Arguments to pass to class (works only in dynamic mode)
     *
     * @return  object Instance of the given class
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     */
    public function build($classname, $arguments = null)
    {
        // check if all required dependencies are set [Di_Factory, Di_Map, ...]
        if (!$this->requirementsFulfilled()) {
            throw new Di_Exception(
                'Error building an instance. Requirements not fulfilled. Provide all required dependencies.'
            );
        }

        // get setup for static || dynamic
        if ($this->_mode === self::MODE_DYNAMIC) {
            $setup = $this->getMap()->getCollection()->getSetup($classname);

        } else {
            $setup = $this->getMap()->getCollection()->getSetup($classname);
            //$setup = $this->getMap()->buildCollection($classname)->getSetup($classname);

        }

        // store arguments if given
        if ($arguments !== null && is_array($arguments)) {
            $setup['arguments'] = $arguments;
        }


        // check if a setup exists
        if ($setup['dependencies'] === null) {
            throw new Di_Exception(
                'Error building instance. No setup for class "'.$classname.'" found!'
            );
        }

        // build and return the object
        return $this->getFactory()->build(
            $classname,
            $setup
        );
    }

    /**
     * Checks if the requirements are fulfilled
     *
     * This method is intend to check if the requirements are fulfilled.
     *
     * @return  boolean TRUE if requirements fulfilled, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @static
     */
    public function requirementsFulfilled()
    {
        // get map
        $map = $this->getMap();

        // check map
        if ($map && $map->getCollection()) {
            return true;
        }

        // failed
        return false;
    }

    /**
     * Singleton Constructor
     *
     * This method is intend to construct and return a singleton instance of
     * Di_Container. Each container singleton is bound to a namespace (eg. 'default').
     * By passing a namespace through argument $namespace you are able to create
     * more than one instance of container if needed/required by your application.
     *
     * @param string  $namespace The namespace of the Di_Container instance
     * @param integer $mode      The mode used to handle maps
     *
     * @return  Di_Container Instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @static
     */
    public static function getInstance($namespace = self::DEFAULT_NAMESPACE, $mode = self::MODE_STATIC)
    {
        if (!isset(self::$_instances[$namespace])) {
            self::$_instances[$namespace] = new self(
                $namespace, $mode
            );
        }

        // return instance
        return self::$_instances[$namespace];
    }

    /*******************************************************************************************************************
     * PRIVATE
     ******************************************************************************************************************/

    /**
     * merges a new map with existing one
     *
     * This method is intend to merge an already existing map with a new one.s
     *
     * @param Di_Map $target The map in which the $source is merged into
     * @param Di_Map $source The map which is merged into $target
     *
     * @return  Di_Container The current instance of the Container for chaining/fluent-interface
     * @access  private
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    private function _mergeMaps(Di_Map $target, Di_Map $source)
    {
        // import of dependencies is built in functionality of map
        $target->import(
            $source->export()
        );

        // set state to state of source class
        //$target->setLastProcessedClass($source->getLastProcessedClass());

        // return the filled target
        return $target;
    }

    /**
     * Constructor
     *
     * This method is the constructor.
     *
     * @param string  $namespace The namespace to operate
     * @param integer $mode      The mode used to handle maps
     *
     * @return  Di_Container The current instance of the Container for chaining/fluent-interface
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    private function __construct($namespace, $mode)
    {
        $this->_namespace = $namespace;
        $this->_mode      = $mode;
    }
}

?>
