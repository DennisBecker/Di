<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Exporter Abstract
 *
 * Abstract.php - Abstract base class for all Exporter of the Di-Framework
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
 * @subpackage Di_Framework_Exporter_Abstract
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */

require_once DI_PATH_LIB_DI.'Exception.php';

/**
 * Di Exporter Abstract
 *
 * Abstract base class for all Exporter of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Exporter_Abstract
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
abstract class Di_Exporter_Abstract
{
    /**
     * Contains all dependencies as Di_Collection
     *
     * @var Di_Collection
     * @access protected
     */
    protected $collection;

    /**
     * Contains the output
     *
     * @var mixed
     * @access protected
     */
    protected $output;


    /*******************************************************************************************************************
     * PUBLIC API
     ******************************************************************************************************************/

    /**
     * Sets the collection of the current instance
     *
     * This method is intend to set the collection of dependencies of the current instance.
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

        // fluent / chaining
        return $this;
    }

    /**
     * Returns the collection of the current instance
     *
     * This method is intend to return the collection of dependencies of the current instance.
     *
     * @return  Di_Collection The collection of dependencies
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
     * Sets the output
     *
     * This method is intend to set the output.
     *
     * @param mixed $output The output to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setOutput($output)
    {
        // reset on setting new output!
        $this->reset();

        $this->output = $output;

        // fluent / chaining
        return $this;
    }

    /**
     * Returns the output
     *
     * This method is intend to return the output.
     *
     * @return  mixed The output
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Resets the output
     *
     * This method is intend to reset the output.
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function reset()
    {
        $this->output = null;

        // fluent / chaining
        return $this;
    }

    /*******************************************************************************************************************
     * PRIVATE
     ******************************************************************************************************************/

    /**
     * Writes content to a given file
     *
     * This method is intend to write content to a given file
     *
     * @param string $file The file to read from
     *
     * @return  void
     * @access  protected
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     * @throws  Di_Exception
     */
    protected function writeFile($file, $data)
    {
        /*
        if (file_exists($file)) {
            throw new Di_Exception(
                'Error writing file. File "'.$file.'" already exist! Could not overwrite - not allowed!'
            );
        }
        */

        return file_put_contents(
            $file,
            $data
        );
    }
}

?>
