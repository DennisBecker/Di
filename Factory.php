<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Factory
 *
 * Factory.php - Factory of the Di-Framework
 *
 * PHP versions 5
 *
 * LICENSE:
 * DoozR - The PHP-Framework
 *
 * Copyright (c) 2005 - 2012, Benjamin Carl - All rights reserved.
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
 * @subpackage Di_Framework_Factory
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2005 - 2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       http://doozr.clickalicious.de
 * @see        -
 * @since      File available since Release 1.0.0
 */

include_once 'Exception.php';

/**
 * Di Factory
 *
 * Factory - Factory of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Factory
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2005 - 2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       http://doozr.clickalicious.de
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Factory
{
    /**
     * Contains an reflection-class-instance of the
     * currently processed class
     *
     * @var ReflectionClass
     * @access private
     */
    private $_reflector;

    /**
     * Contains the is-instanciable status of the
     * currently process class
     *
     * @var boolean
     * @access private
     */
    private $_instanciable;

    /**
     * Contains the name of the constructor-method of
     * the currently process class
     *
     * @var string
     * @access private
     */
    private $_constructor;


    /**
     * Instanciates a class without further dependencies
     *
     * This method is intend to instanciate a class. The classname is the name of the class to instanciate
     * and arguments is an (optional) array of arguments which are passed to the class as additional arguments
     * when instanciating.
     *
     * @param string $classname The name of the class to instanciate
     * @param mixed  $arguments Can be either a list of additional arguments passed to constructor when instance get
     * 						    created or NULL if no arguments needed (default = null)
     *
     * @return  object The new created instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function get($classname, $arguments = null, $setup = null)
    {
        // get refelction
        $this->_reflector = new ReflectionClass($classname);

        // check if is instanciable (simple mode)
        $this->_instanciable = $this->_reflector->isInstantiable();

        if (!$this->_instanciable) {
            $this->_constructor = $this->profile($classname, $this->_reflector);
        }

        // default
        if ($setup) {
            // create instance with dependencies
            return $this->instanciateWithDependencies($classname, $setup, $arguments);
        } else {
            // creat instance without dependencies
            return $this->instanciateWithoutDependencies($classname, $arguments);
        }
    }

    /**
     * Instanciates a class without further dependencies
     *
     * This method is intend to instanciate a class. The classname is the name of the class to instanciate
     * and arguments is an (optional) array of arguments which are passed to the class as additional arguments
     * when instanciating.
     *
     * @param string $classname The name of the class to instanciate
     * @param mixed  $arguments Can be either a list of additional arguments passed to constructor when instance get
     * 						    created or NULL if no arguments needed (default = null)
     *
     * @return  object The new created instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function instanciateWithoutDependencies($classname, $arguments = null)
    {
        if ($this->_instanciable) {
            if ($arguments) {
                $instance = $this->_reflector->newInstanceArgs($arguments);
            } else {
                $instance = new $classname();
            }
        } else {
            if ($arguments) {
                $instance = call_user_func_array(array($classname, $this->_constructor), $arguments);
            } else {
                $instance = call_user_func(array($classname, $this->_constructor));
            }
        }

        return $instance;
    }

    /**
     * Instanciates a class including it dependencies
     *
     * This method is intend to instanciate a class and pass the required dependencies to it.
     * The depencies are preconfigured and passed to this method as $setup. The classname is
     * the name of the class to instanciate and arguments is an (optional) array of arguments
     * which are passed to the class as additional arguments when instanciating.
     *
     * @param string $classname The name of the class to instanciate
     * @param array  $setup     The setup for instanciating (contains array of depencies, arguments, ...)
     * @param mixed  $arguments Can be either a list of additional arguments passed to constructor when instance get
     * 						    created or NULL if no arguments needed (default = null)
     *
     * @return  object The new created instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function instanciateWithDependencies($classname, $setup, $arguments = null)
    {
        // assume empty instance
        $instance     = null;
        $dependencies = $setup['dependencies'];
        $arguments    = (!$arguments) ? $setup['arguments'] : $arguments;

        // hold the 3 possible methods of injection (constructor, method, property)
        $constructor = array();
        $setter      = array();
        $property    = array();

        // iterate over config
        foreach ($dependencies as $dependency => $parameter) {
            if (!$parameter['instance']) {
                // create
                if ($parameter['arguments']) {
                    $dependencyInstance = $this->construct($dependency, $parameter['arguments']);
                } else {
                    $dependencyInstance = new $dependency();
                }

                // store
                $dependencies[$dependency]['instance'] = $dependencyInstance;
            }

            // extract
            switch ($parameter['configuration']['type']) {
            case 'constructor':
                $constructor[] = $dependencies[$dependency]['instance'];
                break;
            case 'setter':
                $setter[]      = array(
                    'instance' => $dependencies[$dependency]['instance'],
                    'value'   => $parameter['configuration']['value']
                );
                break;
            case 'property':
                $property[]    = array(
                    'instance' => $dependencies[$dependency]['instance'],
                    'value'   => $parameter['configuration']['value']
                );
                break;
            }
        }

        // work the constructor injection(s)
        if (!empty($constructor)) {
            if ($this->_instanciable) {
                if ($arguments) {
                    // merge arguments into the dependencies
                    $arguments = array_merge($constructor, $arguments);

                    // create
                    $instance = $this->construct($classname, $arguments);
                }
            } else {
                if ($arguments) {
                    // merge arguments into the dependencies
                    $arguments = array_merge($constructor, $arguments);

                    // create
                    $instance = call_user_func_array(array($classname, $this->_constructor), $arguments);
                }
            }

        } else {
            if ($arguments) {
                // create
                $instance = $this->construct($classname, $arguments);
            } else {
                $instance = new $classname();
            }
        }

        // work setter injections on instance
        if (!empty($setter)) {
            foreach ($setter as $injection) {
                $instance->{$injection['value']}($injection['instance']);
            }
        }

        // work property injections on instance
        if (!empty($property)) {
            foreach ($property as $injection) {
                $instance->{$injection['value']} = $injection['instance'];
            }
        }

        return $instance;
    }

    /**
     * Parse out the constructor for singleton classes
     *
     * This method is intend to parse out the name of the constructor. This method is used for singleton classes
     * or classes which can not be instanciated via "new" operator.
     *
     * @param string          $classname The name of the class to analyze
     * @param ReflectionClass $reflector An ReflectionClass-Instance of the class (optional)
     *
     * @return  string The name of the method which act as constructor
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function profile($classname, $reflector = null)
    {
        // if called from outside we maybe need a new instance of reflection
        if (!$reflector) {
            $reflector = new ReflectionClass($classname);
        }

        // get filename of class
        $classfile = $reflector->getFileName();

        // read the file as array
        $sourcecode = file($classfile);

        // lets find the "real" constructor -> the instance can only be created by a static method
        $possibleConstructors = $reflector->getMethods(ReflectionMethod::IS_STATIC);

        // default no constructor
        $constructor = null;

        // iterate over static methods and check for instantiation
        foreach ($possibleConstructors as $possibleConstructor) {
            $start = $possibleConstructor->getStartLine()+1;
            $end   = $possibleConstructor->getEndline()-1;
            $methodSourcecode = '';

            // concat sourcecode lines
            for ($i = $start; $i < $end; ++$i) {
                $methodSourcecode .= $sourcecode[$i];
            }

            // check for instantiation
            if (strpos($methodSourcecode, 'new self(') || strpos($methodSourcecode, 'new '.$classname.'(')) {
                $constructor = $possibleConstructor->name;
                break;
            }
        }

        // return the name of constructor method
        return $constructor;
    }

    /**
     * Constructs an instance of a given class
     *
     * This method is intend to construct an instance of a given class and pass the given (optional) arguments
     * to the constructor. This method looks really ugly and i know this of course. But this way is a tradeoff
     * between functionality and speed optimization.
     *
     * @param string $classname The name of the class to instanciate
     * @param array  $arguments The arguments to pass to constructor
     *
     * @return  object Instance of given class(name)
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     */
    public function construct($classname, array $arguments = array())
    {
        switch(count($arguments)) {
        case 0:
            return new $classname();
        case 1:
            return new $classname($arguments[0]);
        case 2:
            return new $classname($arguments[0],$arguments[1]);
        case 3:
            return new $classname($arguments[0],$arguments[1],$arguments[2]);
        case 4:
            return new $classname($arguments[0],$arguments[1],$arguments[2],$arguments[3]);
        case 5:
            return new $classname($arguments[0],$arguments[1],$arguments[2],$arguments[3],$arguments[4]);
        case 6:
            return new $classname($arguments[0],$arguments[1],$arguments[2],$arguments[3],$arguments[4],$arguments[5]);
        default:
            throw new Di_Exception(
                'Too much arguments passed to '.__METHOD__.'. This method can handle not more than 6 arguments'.
                'Your class seems to have a architecturial problem. Please reduce count of arguments passed to'.
                'constructor'
            );
        }
    }
}

?>
