<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Map
 *
 * Map.php - Map class of the Di-Framework
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
 * @subpackage Di_Framework_Map
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */

//require_once DI_PATH_LIB_DI.'Exception.php';

/**
 * Di Map
 *
 * Map class of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Map
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Map
{
    /**
     * The name/identifier of this map
     *
     * @var string
     * @access protected
     */
    protected $namespace = self::DEFAULT_NAMESPACE;

    /**
     * Contains all dependencies as collection (array)
     *
     * @var Di_Collection
     * @access protected
     */
    protected $collection;

    /**
     * A Di_Dependency instance to clone objects from
     *
     * @var Di_Dependency
     * @access protected
     */
    protected $dependency;

    /**
     * A * parser instance
     *
     * @var Di_Parser_*
     * @access protected
     */
    protected $parser;

    /**
     * Available wire modes
     * WIRE_MODE_MANUAL    = Wiring is done manually by you
     * WIRE_MODE_AUTOMATIC = Wiring is done automatically
     *
     * @var integer
     * @access public
     */
    const WIRE_MODE_MANUAL    = 1;
    const WIRE_MODE_AUTOMATIC = 2;

    /**
     * Default namespace
     *
     * @var string
     * @access public
     */
    const DEFAULT_NAMESPACE   = 'Di';

    /*******************************************************************************************************************
     * PUBLIC API
     ******************************************************************************************************************/

    /**
     * Sets the collection of the map instance
     *
     * This method is intend to set the collection (Di_Collection) of
     * this map instance.
     *
     * @param Di_Collection $collection The collection to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setCollection(Di_Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Returns the collection of the map instance
     *
     * This method is intend to return the collection (Di_Collection) of
     * this map instance.
     *
     * @return  mixed Di_Collection if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * Sets the identifier of the map instance
     *
     * This method is intend to set the identifier of the map instance.
     *
     * @param string $namespace The identifier to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Returns the identifier of the map instance
     *
     * This method is intend to return the identifier of the map instance.
     *
     * @return  string The namespace of this instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Imports a collection of dependencies
     *
     * This method is intend to import a collection of dependencies (Di_Collection)
     *
     * @param Di_Collection $collection An instance of
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function import(Di_Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Exports a collection of dependencies
     *
     * This method is intend to export a collection of dependencies (Di_Collection)
     *
     * @return  Di_Collection A collection of dependencies
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function export()
    {
        return $this->collection;
    }

    /**
     * Wires existing instances of classes
     *
     * This method is intend to connect existing instances from argument $matrix or retrieved from globals
     * with the existing map. This connection is identified by the "id" in the map and the "key" in the
     * array.
     *
     * @param integer $mode   This can be either WIRE_MODE_MANUAL or WIRE_MODE_AUTOMATIC
     * @param array   $matrix A matrix defining the relation between an Id and an Instance as key => value pair
     *
     * @return  boolean TRUE on success, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     */
    public function wire($mode = self::WIRE_MODE_AUTOMATIC, array $matrix = array())
    {
        if ($mode === self::WIRE_MODE_AUTOMATIC) {
            $matrix = $this->_retrieveGlobals();
        }

        if (empty($matrix)) {
            throw new Di_Exception(
                'Error while wiring instances! Mode manual requires an array containing key => value pairs.'
            );
        }

        // now we connect our map-setup with existing (real) instances
        $this->_wireClassWithDependencies($matrix);

        // success
        return true;
    }

    /**
     * Resets the state of this class
     *
     * This method is intend to reset the state of this class. Currently only used for unit-testing.
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function reset()
    {
        $this->collection = null;
    }

    /*******************************************************************************************************************
     * PROTECTED
     ******************************************************************************************************************/

    /**
     * Adds the given raw dependencies (array) to the collection for given classname
     *
     * This method is intend to add the given raw dependencies (array) to the collection for given classname.
     *
     * @param string $classname       The name of the class the dependencies belong to
     * @param array  $rawDependencies The dependencies as raw array
     *
     * @return  void
     * @access  protected
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    protected function addRawDependenciesToCollection($classname, array $rawDependencies)
    {
        // iterate raw dependencies, convert to Di_Dependency and add it to Di_Collection
        foreach ($rawDependencies as $identifier => $dependencies) {

            foreach ($dependencies as $setup) {
                if ($setup['type'] === 'constructor' && $identifier !== '__construct') {
                    $this->getCollection()->setConstructor($classname, $identifier);
                }

                // tricky clone base dependency object so we don't need a new operator here
                $dependency = clone $this->dependency;

                $dependency->setClassname($setup['class']);
                $dependency->setIdentifier($setup['identifier']);
                $dependency->setConfiguration(
                    array('type' => $setup['type'], 'value' => $setup['value'], 'position' => $setup['position'])
                );

                $this->getCollection()->addDependency($classname, $dependency);
            }
        }
    }

    /*******************************************************************************************************************
     * PRIVATE
     ******************************************************************************************************************/

    /**
     * Wires the map with given (existing) instances
     *
     * This method is used to wire the instances given via arguments $matrix with
     * the corresponding Id's from the static map.
     *
     * @param array $matrix The matrix containing the instances for wiring (id => instance)
     *
     * @return  void
     * @access  private
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     * (non-PHPdoc)
     * @see Di_Importer_Interface::wire()
     */
    private function _wireClassWithDependencies(array $matrix)
    {
        /* @var $this->collection Di_Collection */
        foreach ($this->collection as $dependencies) {

            /* @var $dependency Di_Dependency */
            foreach ($dependencies as $dependency) {

                // if dependency is set to NULL set dependency retrieved from given matrix
                if ($dependency->getInstance() === null) {

                    // some basic failure prevention
                    if (!isset($matrix[$dependency->getIdentifier()])) {
                        throw new Di_Exception(
                            'Error while wiring instance from map with dependency. Instance with identifier: '.
                            '"'.$dependency->getIdentifier().'" does not exist!'
                        );
                    }

                    $dependency->setInstance(
                        $matrix[$dependency->getIdentifier()]
                    );
                }
            }
        }

        // success
        return true;
    }

    /**
     * Returns all variables from global scope
     *
     * This method is intend to return all variables from PHP's global scope.
     *
     * @return  array The defined variables from global scope
     * @access  private
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    private function _retrieveGlobals()
    {
        // retrieve globals and return them
        global $GLOBALS;
        return $GLOBALS;
    }
}

?>
