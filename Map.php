<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Map
 *
 * Map.php - Mapping class of the Di-Framework
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
 * @subpackage Di_Framework_Map
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2005 - 2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    SVN: $Id: DoozRSession.class.php 1266 2012-01-10 07:40:12Z benjamin.carl $
 * @link       http://doozr.clickalicious.de
 * @see        -
 * @since      File available since Release 1.0.0
 */

include_once 'Exception.php';

/**
 * Di Map
 *
 * Mapping class of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Map
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2005 - 2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Release: @package_version@
 * @link       http://doozr.clickalicious.de
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Map
{
    private $_name;
    private $_matrix;


    public function __construct($name)
    {
        $this->_name = $name;
    }


    public function getName()
    {
        return $this->_name;
    }



    public function to($bindings, $classname, $arguments = null)
    {
        if (!isset($this->_matrix[$classname])) {
            $this->_init($classname);
        }

        $this->_matrix[$classname]['arguments'] = $arguments;

        foreach ($bindings as $binding) {
            foreach ($binding as $name => $parameter) {
                $this->setDependency(
                    $classname,
                    $name,
                    $parameter[0],
                    $parameter[1],
                    $parameter[2]
                );
            }
        }
    }


    public function setDependency($from, $to, $instance, $arguments, $config)
    {
        $this->_matrix[$from]['dependencies'][$to] = array(
    		'instance'      => $instance,
    		'arguments'     => $arguments,
    		'configuration' => $config
        );
    }


    public function get($classname)
    {
        if (!$classname) {
            return $this->_matrix;
        } else {
            if (!isset($this->_matrix[$classname])) {
                return null;
            }

            return $this->_matrix[$classname];
        }
    }



    private function _init($classname)
    {
        $this->_matrix[$classname] = array(
            'arguments'    => array(),
            'dependencies' => array()
        );
    }
}

?>
