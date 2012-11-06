<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../Lib/Di/Bootstrap.php';


/**
 * Required classes (files) for annotation demonstration #2
 */
require_once DI_PATH_LIB.'Collection.php';
require_once DI_PATH_LIB.'Parser/Annotation.php';
require_once DI_PATH_LIB.'Map/Annotation.php';
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
 * create instances for wiring
 */
$Database1 = new Database('mysql://user:password@server/database');
$Logger1   = new Logger('Foo', 'Bar');


/**
 * create instances of required classes
 * create instance of Di_Map_Annotation and pass required classes as arguments to constructor
 */
$collection = new Di_Collection();
$parser     = new Di_Parser_Annotation();
$dependency = new Di_Dependency();
$map        = new Di_Map_Annotation($collection, $parser, $dependency);


/**
 * generate map from annotation ins source of class "Bar"
 */
$map->generate('Bar');


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
