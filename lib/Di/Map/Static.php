<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Di Map Static
 *
 * Static.php - Static map class of the Di-Framework
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
 * @subpackage Di_Framework_Map_Static
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @version    Git: $Id: $
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */

//require_once DI_PATH_LIB_DI.'Map.php';

/**
 * Di Map Static
 *
 * Static map class of the Di-Framework
 *
 * @category   Di
 * @package    Di_Framework
 * @subpackage Di_Framework_Map_Static
 * @author     Benjamin Carl <opensource@clickalicious.de>
 * @copyright  2012 Benjamin Carl
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 * @link       https://github.com/clickalicious/Di
 * @see        -
 * @since      File available since Release 1.0.0
 */
class Di_Map_Static extends Di_Map
{
    /**
     * An instance of Di_Importer_*
     *
     * @var Di_Importer_*
     * @access protected
     */
    protected $importer;


    /*******************************************************************************************************************
     * PHP CONSTRUCT
     ******************************************************************************************************************/

    /**
     * Constructor
     *
     * Constructor of this class
     *
     * @param Di_Collection    $collection An instance of Di_Collection to collect dependencies in
     * @param Di_Importer_Json $importer   An instance of Di_Importer_Json to import dependencies with
     *
     * @return  void
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function __construct(Di_Collection $collection, Di_Importer_Json $importer)
    {
        // store given instances
        $this->collection = $collection;
        $this->importer   = $importer;

        $this->importer->setCollection($collection);
    }

    /*******************************************************************************************************************
     * PUBLIC API
     ******************************************************************************************************************/

    /**
     * Builds the collection from dependency parser result for given class
     *
     * This method is intend to build the collection from dependency parser result for given class.
     *
     * @param string $filename The name of the file to parse dependencies from
     *
     * @return  Di_Collection The build collection
     * @access  public
     * @author  Benjamin Carl <opensource@clickalicious.de>
     * @since   Method available since Release 1.0.0
     * @version 1.0
     */
    public function generate($filename)
    {
        // set input
        $this->importer->setInput($filename);

        // do the import
        $this->importer->import();
    }
}

?>
