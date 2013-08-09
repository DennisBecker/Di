<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../lib/Di/Bootstrap.php';


/**
 * Required classes (files) for static demonstration #5
 */
require_once DI_PATH_LIB_DI.'Collection.php';
require_once DI_PATH_LIB_DI.'Importer/Json.php';
require_once DI_PATH_LIB_DI.'Exporter/Json.php';
require_once DI_PATH_LIB_DI.'Map/Static.php';
require_once DI_PATH_LIB_DI.'Factory.php';
require_once DI_PATH_LIB_DI.'Container.php';


/**
 * Foo              (class with dependencies to Database, Logger) public constructor
 * Bar              (class with dependencies to Database, Logger) private constructor = singleton
 * Database, Logger (dependencies)
 */
require_once 'class/Foo.php';
require_once 'class/Bar.php';
require_once 'class/Database.php';
require_once 'class/Logger.php';


/**
 * Create instances for wiring
 */
$Database1 = new Database('mysql://user:password@server/database');
$Logger1   = new Logger('Foo', 'Bar');


/**
 * create instances of required classes
 * create instance of Di_Map_Annotation and pass required classes as arguments to constructor
 */
$collection = new Di_Collection();
$importer   = new Di_Importer_Json();
$map        = new Di_Map_Static($collection, $importer);


/**
 * generate map from input "data/map1.json"
 */
$map->generate('data/map1.json');


/**
 * wire the instances automagically for class "Foo" (and all others?)
 */
$map->wire(
    Di_Map::WIRE_MODE_MANUAL,
    array(
        'Logger1'   => $Logger1,
        'Database1' => $Database1
    )
);


/**
 * get instance of our exporter for static JSON exports
 */
$exporter = new Di_Exporter_Json();


/**
 * set collection to exporter
 */
$exporter->setCollection($map->getCollection());


/**
 * set output to file tmp\map1.json
 */
$exporter->setOutput(getcwd().DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'map1.json');


/**
 * do the export
 */
$exporter->export();

echo '<pre>Successfully exported map to file "'.getcwd().DIRECTORY_SEPARATOR.'tmp'.DIRECTORY_SEPARATOR.'map1.json'.'".</pre>';

?>

<p>
    <a href="index.php#Demonstration">Back to index</a>
</p>
