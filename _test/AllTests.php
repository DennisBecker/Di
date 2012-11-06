<?php

/**
 * Bootstrapper of the Di Framework (absolute Path retrieval for Lib)
 */
require_once '../Lib/Di/Bootstrap.php';

/**
 * PHPUnit
 */
require_once 'PHPUnit/Autoload.php';

/**
 * the Tests
 */
require_once 'DependencyTest.php';
require_once 'CollectionTest.php';
require_once 'MapTest.php';
require_once 'FactoryTest.php';
require_once 'ContainerTest.php';
require_once 'Importer/JsonTest.php';
//require_once 'Map/FluentTest.php';
require_once 'Parser/AnnotationTest.php';
require_once 'Parser/ConstructorTest.php';
//require_once 'Parser/DependencyTest.php';



class DiTests_AllTests extends PHPUnit_Framework_TestSuite
{
    protected function setUp() {

    }

    public static function suite()
    {
        $suite = new DiTests_AllTests();

        $suite->addTestSuite('DiTests_DependencyTest');
        $suite->addTestSuite('DiTests_CollectionTest');
        $suite->addTestSuite('DiTests_MapTest');
        $suite->addTestSuite('DiTests_FactoryTest');
        $suite->addTestSuite('DiTests_ContainerTest');
        $suite->addTestSuite('DiTests_Importer_JsonTest');
        //$suite->addTestSuite('DiTests_Map_FluentTest');
        $suite->addTestSuite('DiTests_Parser_AnnotationTest');
        $suite->addTestSuite('DiTests_Parser_ConstructorTest');
        //$suite->addTestSuite('DiTests_Parser_DependencyTest');

        return $suite;
    }
}

?>
