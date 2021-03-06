<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../lib/Di/Bootstrap.php';


/**
 * Required classes (files) for static demonstration #3
 */
require_once DI_PATH_LIB_DI.'Collection.php';
require_once DI_PATH_LIB_DI.'Importer/Json.php';
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
 * generate map from input "data/map3.json"
 */
$map->generate('data/map3.json');


/**
 * wire the instances automagically for class "Foo" (and all others?)
 */
$map->wire();


/**
 * create instances of required classes
 * create instance of Di_Container and set factory created previously
 */
$factory    = new Di_Factory();
$container  = Di_Container::getInstance();
$container->setFactory($factory);


/**
 * store previously created dependency map in container
 */
$container->setMap($map);


/**
 * Everything should be in the right position. We create an instance of
 * class "Bar" now.
 */
$Bar = $container->build('Bar');


/**
 * Test our created instance by calling method test()
 */
$Bar->test();


/**
 * Check against instance
 */
if (get_class($Bar) === 'Bar') {
    echo '<pre>Successfully created instance of class Bar.</pre>';
}


/**
 * Debug output
 */
echo '<pre>';
var_dump($Bar);
echo '</pre>';


/**
 * Now build a second instance of class Bar
 */
$Bar2 = $container->build('Bar');

/**
 * Test our created instance by calling method test()
 */
$Bar2->test();


/**
 * Check against instance
 */
if (get_class($Bar2) === 'Bar') {
    echo '<pre>Successfully created instance of class Bar.</pre>';
}


/**
 * Debug output
 */
echo '<pre>';
var_dump($Bar2);
echo '</pre>';


/**
 * Check that we got two different instances
 */
if ($Bar !== $Bar2) {
    echo '<pre>Everything seems to works fine. We retrieved two separate instances.</pre>';
}

?>

<p>
    <a href="index.php#Demonstration">Back to index</a>
</p>

