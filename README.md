*Di*
================================

***Di*** is the lightweight and powerful dependency injection framework written in and for PHP. ***Di*** supports all currently known and required types of injections (constructor, setter, property).
***Di*** is fully documented and really easy to use. ***Di*** is also under active development and of course it's unit-tested.



Features
-------------------------
* static-, dynamic-, annotation-based- and typehint-based- dependency maps
 * ***Di*** is cappable of parsing dependencies out of "annotations" or just "typehints", can import dependencies from static JSON-based (filesystem) dependency maps and can handle at runtime defined dependencies (fluent interface).

* automagic wiring
  * ***Di*** can automatically look in the global scope for an existing instance of the defined class and use this if found for wiring

* clear project-structure and clean code
  * So it is really easy for you to get an detailed overview of what's going on in ***Di***.

* no external dependencies
  * ***Di*** does not need any special PHP-extension

* Fully documented
  * Every part in ***Di*** is covered by a comment and/or an detailed howto

* Unit-Tested
  * ***Di*** ist well tested and used in production environment

* easy to use
  * ***Di*** provides a very good API for developers



Requirements
-------------------------
***Di*** requires at least PHP 5.3 and has no external dependencies. ***Di*** currently uses the PHP Reflection API to analyze classes. One of the planned features is using a regular expression based parser as replacement for the slow Reflection-API (for more details view **Roadmap**).



How dependency injection works
-------------------------
The dependency injection process is separated into three main parts. These parts cover the process from defining dependencies of a class to creating instances of a class having dependencies.

1. **Creating the dependency map**

 ***Di*** needs to know a lot of information when creating instances via *build()*. The information is stored in a map - the so called *dependency map*.

* **Connect Instances to the dependency map**

 This step is also known as *wiring* and it describes the creation of a relation between an instance of a class and the *dependency map* created in the previous step.

* **Building instances through the container**

 Instead of creating instances like you did it before (e.g.) *$Foo = new foo($dependency);* you must now use the ***Di***-*container* to create instances. This is done by simply calling the build() method of your ***Di***-*container* instance. See **box 1** for an example call:

**box 1**

    $Foo = $container->build('foo');



Usage
-------------------------
***Di*** can be used in four mainly different ways:

1. The *1st* way is using ***Di*** in combination with *static* dependency maps. This feature is required by systems (like frameworks) which for example generate the map automatically or retrieve dependencies from external sources.

* The *2nd* and recommended way is using ***Di*** with *dynamic* build dependency maps. These maps can be build through a *fluent interface*. This is the easiest way for small projects and as a sideeffect: it produces good readable code (as recommended by Martin Fowler). See the **box 2** for an example call:

3. The 3rd way is using ***Di*** with *dynamic* build annotation based dependency maps. You only need to define the dependencies of a class in the PHPDoc class comment and make use of the *Di_Map_Annotation*  parser to retrieve a map ...

4. The 4th way is using Di with Typehint based dependency maps. You only need to define the correct typehints within your classes and the Di_Map_Typehint parser does all the work for you.

**box 2**

    $Foo = $map
        ->classname('Foo')
        ->dependsOn('Database')
        ->id('Database1')
        ->instance($Database1)
        ->configuration(array('type' => Di_Dependency::TYPE_CONSTRUCTOR, 'position' => 1))
                   ->build(array('custom argument passed to Foo()'));



Demonstration
-------------------------
You will find detailed demonstrations (and the corresponding sourcecode) in the folder ***./_demo/***. This should give you a good overview of what is possible with ***Di*** and what is (currently) not. The demonstrations cover the following topics:

* How to inject dependencies using a ...
 * ***static*** *dependency map* (JSON format) and manually wiring
 * ***static*** *dependency map* (JSON format) and automatic wiring (magic)
 * ***static*** *dependency map* (JSON format) and a class with singleton pattern
 * ***dynamic*** *dependency map* (fluent Interface) and manually wiring
 * ***dynamic*** *dependency map* (fluent Interface) and automatic wiring (magic)
 * ***dynamic*** *dependency map* (fluent Interface) and a class with singleton pattern
 * ***annotation*** dependency map (annotations inline) and manually wiring
 * ***annotation*** dependency map (annotations inline) and automatic wiring (magic)
 * ***annotation*** dependency map (annotations inline) and a class with singleton pattern
 * ***typehint*** dependency map (plain vanilla PHP) and manually wiring
 * ***typehint*** dependency map (plain vanilla PHP) and automatic wiring (magic)
 * ***typehint*** dependency map (plain vanilla PHP) and a class with singleton pattern 

    
API Documentation
-------------------------
The sourcecode is fully documented and you will find the documentation in the folder ***./_doc/html/***.


Roadmap
-------------------------
This is the current roadmap of new features:

* Map-builder which takes a Di_Collection as input and creates (build/write) a static dependency map (e.g. in JSON-Format) of it

* Storing of required dependencies within the static dependency map (PHP Object Freezer https://github.com/sebastianbergmann/php-object-freezer)

* Increasing code-coverage of the Unit-Tests from approximately 79% up to ~100% ;)


-------------------------

Benjamin Carl | PHPFlüsterer
Software-Architect

Visit my Blog for the latest news - www.phpfluesterer.de
