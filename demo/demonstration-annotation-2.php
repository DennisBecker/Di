<?php

/**
 * simple absolute path bootstrapping for better performance
 */
require_once '../lib/Di/Bootstrap.php';


/**
 * Required classes (files) for annotation demonstration #2
 */
require_once DI_PATH_LIB_DI.'Collection.php';
require_once DI_PATH_LIB_DI.'Parser/Annotation.php';
require_once DI_PATH_LIB_DI.'Map/Annotation.php';
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
 * generate map from annotation ins source of class "Foo"
 */
$map->generate('Foo');


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
