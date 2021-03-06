<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Importer Abstract
 *
 * Abstract.php - Abstract base class for all Importer of the Di-Framework
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
 * @subpackage Di_Framework_Importer_Abstract
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
 * Di Importer Abstract
 *
 * Abstract base class for all Importer of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Importer_Abstract
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
abstract class Di_Importer_Abstract
{
    /**
     * Contains all dependencies as Di_Collection
     *
     * @var Di_Collection
     * @access protected
     */
    protected $collection;

    /**
     * Contains the input
     *
     * @var mixed
     * @access protected
     */
    protected $input;


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
     * Sets the input
     *
     * This method is intend to set the input.
     *
     * @param mixed $input The input to set
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function setInput($input)
    {
        // reset on setting new input!
        $this->reset();

        $this->input = $input;

        // fluent / chaining
        return $this;
    }

    /**
     * Returns the input
     *
     * This method is intend to return the input.
     *
     * @return  mixed The input
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Resets the input
     *
     * This method is intend to reset the input.
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function reset()
    {
        $this->input = null;

        // fluent / chaining
        return $this;
    }

    /*******************************************************************************************************************
     * PRIVATE
     ******************************************************************************************************************/

    /**
     * Reads content from given file
     *
     * This method is intend to read content from given file and store it in $content.
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
    protected function readFile($file)
    {
        if (!file_exists($file) || !is_file($file)) {
            throw new Di_Exception(
                'Error reading file. File "'.$file.'" does not exist or is not a valid file'
            );
        }

        return file_get_contents($file);
    }
}

?>
