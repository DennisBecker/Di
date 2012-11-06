<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../Lib/Di/Bootstrap.php';


/**
 * Required classes (files) for fluent demonstration #2
 */
require_once DI_PATH_LIB.'Collection.php';
require_once DI_PATH_LIB.'Dependency.php';
require_once DI_PATH_LIB.'Map/Fluent.php';
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
 *
 * I've used the variable names $Database1 and $Logger1 to show you
 * the magic of automatic wiring in Demonstration #2. So i kept the
 * names always like in Demontration #2 so it easier to follow.
 */
$Database1 = new Database('mysql://user:password@server/database');
$Logger1   = new Logger('Foo', 'Bar');


/**
 * For the next step we need an plain Di_Map instance. The map could now
 * be filled like in Example #1 or #2 but i will show you how to make
 * use of the static map ...
 */
$collection = new Di_Collection();
$dependency = new Di_Dependency();
$map        = new Di_Map_Fluent($collection, $dependency);


/**
 * In this demonstration we create a map through fluent interface.
 * Here we bind the class "Database" with the existing instance "$Database1"
 * and the class "Logger" with its existing instance "$Logger1" to the class
 * Foo
 */
$map->generate()

	->classname('Foo', array('Foo', 'Bar'))

	->dependsOn('Database')
	->id('Database1')
	->configuration(
		array('type' => Di_Dependency::TYPE_CONSTRUCTOR, 'position' => 1)
	)

	->dependsOn('Logger')
	->id('Logger1')
	->configuration(
		array('type' => Di_Dependency::TYPE_METHOD, 'value' => 'setLogger')
	);


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
 * class "Foo" now.
 */
$Foo = $container->build('Foo');


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
$Foo2 = $container->build('Foo');

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
