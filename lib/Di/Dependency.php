<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Dependency
 *
 * Dependency.php - Dependency class of the Di-Framework
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
 * @subpackage Di_Framework_Dependency
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */

/**
 * Di Dependency
 *
 * Dependency class of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Dependency
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Dependency implements ArrayAccess
{
    /**
     * The name of the class of a single dependency
     *
     * @var string
     * @access private
     */
    private $_classname;

    /**
     * An existing instance to use instead of creating a new one
     *
     * @var object
     * @access private
     */
    private $_instance;

    /**
     * The arguments which are passed to the constructor of $_classname
     * when creating a new instance.
     *
     * @var array
     * @access private
     */
    private $_arguments;

    /**
     * The constructor for creating fresh instances of the dependency(class).
     *
     * @var string
     * @access private
     */
    private $_constructor;

    /**
     * The configuration of this dependency.
     * Contains type of injection and the value
     * (eg. type = method, value = setFoo)
     *
     * @var array
     * @access private
     */
    private $_configuration;

    /**
     * The identifier eg. used for wiring
     *
     * @var string
     * @access private
     */
    private $_identifier;

    /**
     * Class constants
     *
     * @var const
     * @access public
     */
    const TYPE_CONSTRUCTOR = 'constructor';
    const TYPE_METHOD      = 'method';
    const TYPE_PROPERTY    = 'property';


    /*******************************************************************************************************************
     * PHP CONSTRUCT
     ******************************************************************************************************************/

    /**
     * Constructor
     *
     * This method is the constructor.
     *
     * @param string $classname The name of the class (the dependency)
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function __construct($classname = null)
    {
        $this->_classname = $classname;
    }

    /*******************************************************************************************************************
     * PUBLIC API
     ******************************************************************************************************************/

    /**
     * Sets the name of the class
     *
     * This method is intend to set the name of the class.
     *
     * @param string $classname The name of the class to set
     *
     * @return  boolean TRUE on success, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setClassname($classname)
    {
        return ($this->_classname = $classname);
    }

    /**
     * Returns the name of the class
     *
     * This method is intend to return the name of the class.
     *
     * @return  string The name of the dependency class
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getClassname()
    {
        return $this->_classname;
    }

    /**
     * Sets the instance of the class
     *
     * This method is intend to set the instance of the class.
     *
     * @param object $instance The instance to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setInstance($instance)
    {
        $this->_instance = $instance;
    }

    /**
     * Returns the instance of the class
     *
     * This method is intend to return the instance of the class.
     *
     * @return  object The instance of the dependency class
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getInstance()
    {
        return $this->_instance;
    }

    /**
     * Sets the identifier of the current instance
     *
     * This method is intend to set the identifier of the current instance.
     *
     * @param string $identifier The identifier to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setIdentifier($identifier)
    {
        $this->_identifier = $identifier;
    }

    /**
     * Returns the identifier of the current instance
     *
     * This method is intend to return the identifier of the current instance.
     *
     * @return  string The identifier of the instance
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getIdentifier()
    {
        return $this->_identifier;
    }

    /**
     * Sets the arguments of the class
     *
     * This method is intend to set the arguments of the class.
     *
     * @param array $arguments The arguments to set
     *
     * @return  boolean TRUE on success, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setArguments(array $arguments)
    {
        return ($this->_arguments = $arguments);
    }

    /**
     * Returns the arguments of the class
     *
     * This method is intend to return the arguments of the class.
     *
     * @return  mixed Array containing arguments if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getArguments()
    {
        return $this->_arguments;
    }

    /**
     * Returns TRUE if this dependency has arguments, otherwise FALSE
     *
     * This method is intend to return TRUE if this dependency has arguments for instanciation,
     * otherwise FALSE.
     *
     * @return  boolean TRUE if this dependency has arguments, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function hasArguments()
    {
        return isset($this->_arguments);
    }

    /**
     * Sets the constructor of the dependency class
     *
     * This method is intend to set the constructor of the dependency class.
     *
     * @param string $constructor The signature of the constructor
     *
     * @return  boolean TRUE on success, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setConstructor($constructor)
    {
        return ($this->_constructor = $constructor);
    }

    /**
     * Returns the constructor of the dependency class
     *
     * This method is intend to return the constructor of the dependency class.
     *
     * @return  mixed String containing the signature of the constructor if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getConstructor()
    {
        return $this->_constructor;
    }

    /**
     * Returns TRUE if this dependency has a custom constructor, otherwise FALSE
     *
     * This method is intend to return TRUE if this dependency has a custom constructor for instanciation,
     * otherwise FALSE.
     *
     * @return  boolean TRUE if this dependency has arguments, otherwise FALSE
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function hasConstructor()
    {
        return isset($this->_constructor);
    }

    /**
     * Sets the configuration of the class
     *
     * This method is intend to set the configuration of the class.
     *
     * @param array $configuration The configuration to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setConfiguration(array $configuration)
    {
        $this->_configuration = $configuration;
    }

    /**
     * Returns the configuration of the class
     *
     * This method is intend to return the configuration of the class.
     * If not set the default return value is returned. The default is
     * type => constructor.
     *
     * @return  mixed Array containing arguments if set, otherwise NULL
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getConfiguration()
    {
        return (!$this->_configuration)
            ? array('type' => 'constructor')
            : $this->_configuration;
    }

    /**
     * Returns the current dependency as array
     *
     * This method is intend to return the current dependency setup as array.
     *
     * @return  array The dependency setup
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function asArray()
    {
        return array(
            'classname'     => $this->_classname,
            'instance'      => $this->_instance,
            'arguments'     => $this->_arguments,
            'configuration' => $this->_configuration
        );
    }

    /**
     * Creates a random unique Id for this instance
     *
     * This method is intend to create and return an unique Id of
     * the current instance of this class.
     *
     * @return  string The random and unique Id
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getRandomId()
    {
        $bytes = $this->getBytes(64);
        return sha1(serialize($this).$bytes);
    }

    /**
     * Generate string random bytes as random salt for getRandomId()
     *
     * @param int $length
     * @throws RuntimeException
     * @return string
     */
    private function getBytes($length)
    {
        if (function_exists('openssl_random_pseudo_bytes')
            && (version_compare(PHP_VERSION, '5.3.4') >= 0
                || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
        ) {
            $bytes = openssl_random_pseudo_bytes($length, $usable);
            if (true === $usable) {
                return $bytes;
            }
        }
        if (function_exists('mcrypt_create_iv')
            && (version_compare(PHP_VERSION, '5.3.7') >= 0
                || strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN')
        ) {
            $bytes = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
            if ($bytes !== false && strlen($bytes) === $length) {
                return $bytes;
            }
        }

        throw new RuntimeException (
            'Unable to generate sufficiently strong random bytes due to a lack ',
            'of sources with sufficient entropy'
        );
    }


    /*******************************************************************************************************************
     * MAGIC
     ******************************************************************************************************************/

    /**
     * magic __toString
     *
     * This method return the name of the dependency-class
     *
     * @return  string The name of the dependency-class
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function __toString()
    {
        return $this->_classname;
    }

    /*******************************************************************************************************************
     * ARRAY ACCESS
     ******************************************************************************************************************/

    /**
     * Implements offsetExists
     *
     * @param string $offset The offset to check
     *
     * @return boolean TRUE if offset is set, otherwise FALSE
     */
    public function offsetExists($offset)
    {
        return isset($this->{$offset});
    }

    /**
     * Implements offsetGet
     *
     * @param string $offset The offset to return
     *
     * @return mixed The data from offset
     */
    public function offsetGet($offset)
    {
        return $this->{$offset};
    }

    /**
     * Implements offsetSet
     *
     * @param string $offset The offset to set
     * @param mixed  $value  The value to set
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_classname = $value;
        } else {
            $this->{$offset} = $value;
        }
    }

    /**
     * Implements offsetUnset
     *
     * @param string $offset The offset to unset
     *
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->{$offset});
    }
}

?>
