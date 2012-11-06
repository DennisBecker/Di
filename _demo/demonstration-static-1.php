<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../Lib/Di/Bootstrap.php';


/**
 * Required classes (files) for static demonstration #1
 */
require_once DI_PATH_LIB.'Collection.php';
require_once DI_PATH_LIB.'Importer/Json.php';
require_once DI_PATH_LIB.'Map/Static.php';
require_once DI_PATH_LIB.'Factory.php';
require_once DI_PATH_LIB.'Container.php';


/**
 * Foo 		        (class with dependencies to Database, Logger) public constructor
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
 * class "Foo" now.
 */
$Foo = $container->build('Foo', array('I am a custom argument!'));


/**
 * Test our created instance by calling method test()
 */
$Foo->test();


/**
 * Check against instance
 */
if (get_class($Foo) === 'Foo') {
	echo '<pre>Successfully created instance of class Foo.</pre>';
}


/**
 * Debug output
 */
echo '<pre>';
var_dump($Foo);
echo '</pre>';


/**
 * Now build a second instance of class Foo
 */
$Foo2 = $container->build('Foo', array('I am an other custom argument!'));

/**
 * Test our created instance by calling method test()
 */
$Foo2->test();


/**
 * Check against instance
 */
if (get_class($Foo2) === 'Foo') {
	echo '<pre>Successfully created instance of class Foo.</pre>';
}


/**
 * Debug output
 */
echo '<pre>';
var_dump($Foo2);
echo '</pre>';


/**
 * Check that we got two different instances
 */
if ($Foo !== $Foo2) {
	echo '<pre>Everything seems to works fine. We retrieved two separate instances.</pre>';
}

?>

<p>
	<a href="index.php#Demonstration">Back to index</a>
</p>

