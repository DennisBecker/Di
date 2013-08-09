<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Di | the lightweight and powerful dependency injection framework</title>

<style>
    body {
        font-family: 'Times New Roman';
        margin: 0;
        width: 100%;
        background-color: #eee;
    }

    a {
        color: #333;
        text-decoration: underline;
    }

    a:active, a:visited {
        color: #333;
        text-decoration: underline;
    }

    a:hover {
        text-decoration: none;
        color: #000;
    }

    #demo {
        margin: 16px 16px 16px 140px;
        width: auto;
        height: auto;
        line-height: 26px;
        font-size: 1.1em;
    }

    #demo span {
        font-style: italic;
        font-weight: bold;
    }

    span.snippet {
        font-size: 0.8em;
        font-weight: normal;
        font-family: 'Courier new';
    }

    ol {
        font-weight: bold;
    }

    li {
        margin-bottom: 12px;
    }

    li p {
        margin: 0;
        padding: 0;
        font-weight: normal;
    }

    h3 {
        margin-top: 26px;
        margin-bottom: 12px;
    }

    .smaller {
        font-family: 'Estrangelo Edessa', Arial;
        font-size: 0.8em !important;
        font-weight: normal !important;
        font-style: normal !important;
        color: #333 !important;
    }

</style>

</head>
<body>

<a href="http://github.com/clickalicious">
    <img style="position: fixed; top: 0; left: 0; border: 0;" src="https://githubbadge.appspot.com/image/icon-fork-me.png" alt="Fork me on GitHub">
</a>

<div id="demo">
<h2><i>Di</i></h2>
    <span>Di</span> is the lightweight and powerful dependency injection framework written in and for PHP. <span>Di</span> supports all currently known and required types of injections (constructor, setter, property).&nbsp;
    <span>Di</span> is fully documented and really easy to use. <span>Di</span> is also under active development and of course it's unit-tested.<br />



    <h3>Features</h3>
    <ul>
        <li>
            <i>static-</i>, <i>dynamic-</i>, <i>annotation-based-</i> and <i>typehint-based-</i> dependency maps<br />
            <span class="smaller">Di is cappable of parsing dependencies out of "annotations" or just "typehints",<br />
            can import dependencies from static JSON-based (filesystem) dependency maps<br />
            and can handle at runtime defined dependencies (fluent interface).
        </li>
        <li>
            <i>automagic wiring</i><br />
            <span class="smaller">Di can automatically look in the global scope for an existing instance of the defined class and use this if found for wiring</span>
        </li>
        <li>
            clear project-structure and clean code<br />
            <span class="smaller">So it is really easy for you to get an detailed overview of what's going on in Di.</span>
        </li>
        <li>
            no external dependencies<br />
            <span class="smaller">Di does not need any special PHP-extension</span>
        </li>
        <li>
            Fully documented<br />
            <span class="smaller">Every part in Di is covered by a comment and/or a detailed howto</span>
        </li>
        <li>
            Unit-Tested<br />
            <span class="smaller">Di ist well tested and used in production environment</span>
        </li>
        <li>
            easy to use<br />
            <span class="smaller">Di provides a very good API for developers</span>
        </li>
    </ul>



    <h3>Requirements</h3>
    <span>Di</span> requires at least PHP 5.3 and has no external dependencies. <span>Di</span> currently uses the <a href="http://php.net/manual/en/book.reflection.php" target="_blank">PHP Reflection-API</a> to analyze classes.
    One of the planned features is using a regular expression based parser as replacement for the slow Reflection-API (for more details view <a href="#roadmap">Roadmap</a>).



    <h3>How dependency injection works</h3>
    The <i>dependency injection</i> process is separated into three main parts. These parts cover the process from
    <span>defining dependencies of a class</span> to <span>creating instances of a class having dependencies</span>.
    <ol>
        <li>
            <p>
            <span>Creating the dependency map</span><br />
            <span>Di</span> needs to know a lot of information when creating instances via build().<br />
            The information is stored in a map - the so called <i>dependency map</i>.
            </p>
        </li>
        <li>
            <p>
            <span>Connect Instances to the dependency map</span><br />
            This step is also known as <i>wiring</i> and it describes the creation of a relation between <i>an
            instance of a class</i> and the <i>dependency map</i> created in previous step.
            </p>
        </li>
        <li>
            <p>
            <span>Building instances through the container</span><br />
            Instead of creating instances like you did it before (e.g.) <i><span style="color: rgb(0, 0, 187);">$foo</span> <span style="color: rgb(0, 119, 0);">=</span> <span style="color: rgb(153,153,0);">new </span><span style="color: rgb(221, 0, 0);">foo</span><span style="color: rgb(0, 119, 0);">(</span><span style="color: rgb(0, 0, 187);">$dependency</span><span style="color: rgb(0, 119, 0);">);</span></i> you must now
            use the <span>Di</span>-container to create instances.<br />
            This is done by simply calling the <em>build()</em> method of your <span>Di</span>-container instance.

            <blockquote>
                Example call<br />
                <span class="snippet">
                <pre>
<span style="color: rgb(0, 0, 187);">$Foo&nbsp;</span><span style="color: rgb(0, 119, 0);">=&nbsp;</span><span style="color: rgb(0, 0, 187);">$container</span><span style="color: rgb(0, 119, 0);">-&gt;</span><span style="color: rgb(0, 0, 187);">build</span><span style="color: rgb(0, 119, 0);">(</span><span style="color: rgb(221, 0, 0);">'Foo'</span><span style="color: rgb(0, 119, 0);">);&nbsp;</span>
                </pre>
                </span>
            </blockquote>
            </p>
        </li>
    </ol>



    <h3>Usage</h3>
    <span>Di</span> can be used in four mainly different ways:
    <ol>
        <li>
            <p>
            The <i>1st</i> way is using <span>Di</span> in combination with <span>static</span> <i>dependency maps</i>.<br />
            This is feature is required by systems (like frameworks) which for example generate the map automatically or retrieve dependencies from external sources.
            </p>
        </li>
        <li>
            <p>
            The <i>2nd</i> and recommended way is using <span>Di</span> with <span>dynamic</span> build <i>dependency maps</i>.<br />
            These maps can be build through a <i>fluent interface</i>. This is the easiest way for small projects and<br />
            as a sideeffect: it produces good readable code (<a href="https://en.wikipedia.org/wiki/Fluent_interface" target="_blank">as recommended
            by Martin Fowler</a>).<br />
            <blockquote>
                Example call<br />
                <span class="snippet">
                    <pre>
<span style="color: rgb(0, 0, 187);">$Foo&nbsp;</span><span style="color: rgb(0, 119, 0);">=&nbsp;</span><span style="color: rgb(0, 0, 187);">$map
           </span><span style="color: rgb(0, 119, 0);">-&gt;</span><span style="color: rgb(0, 0, 187);">classname</span><span style="color: rgb(0, 119, 0);">(</span><span style="color: rgb(221, 0, 0);">'Foo'</span><span style="color: rgb(0, 119, 0);">)<br /><span style="color: rgb(0, 0, 187);">           </span>-&gt;<span style="color: rgb(0, 0, 187);">dependsOn</span>(<span style="color: rgb(221, 0, 0);">'Database'</span>)<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;</span><span style="color: rgb(0, 0, 187);">id</span><span style="color: rgb(0, 119, 0);">(</span><span style="color: rgb(221, 0, 0);">'Database1'</span><span style="color: rgb(0, 119, 0);">)<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;</span><span style="color: rgb(0, 0, 187);">instance</span><span style="color: rgb(0, 119, 0);">(</span><span style="color: rgb(0, 0, 187);">$Database1</span><span style="color: rgb(0, 119, 0);">)<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;</span><span style="color: rgb(0, 0, 187);">configuration</span><span style="color: rgb(0, 119, 0);">(array(</span><span style="color: rgb(221, 0, 0);">'type'&nbsp;</span><span style="color: rgb(0, 119, 0);">=&gt;&nbsp;</span><span style="color: rgb(221, 0, 0);"><span style="color: rgb(153,153,0);">Di_Dependency::TYPE_CONSTRUCTOR</span></span><span style="color: rgb(0, 119, 0);"><span style="color: rgb(221, 0, 0);">, 'position'&nbsp;</span>=&gt;&nbsp;1))</span><span style="color: rgb(0, 119, 0);"><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&gt;</span><span style="color: rgb(0, 0, 187);">build</span><span style="color: rgb(0, 119, 0);">(array(<span style="color: rgb(221, 0, 0);">'custom argument passed to Foo()</span><span style="color: rgb(221, 0, 0);">'</span>));&nbsp;</span><span style="color: rgb(0, 0, 187);"></span>
                   </pre>
                </span>
            </blockquote>
            </p>
        </li>
        <li>
            <p>
            The <i>3rd</i> way is using <span>Di</span> with dynamic build annotation based dependency maps. You only need to define the dependencies of a class in the PHPDoc class comment and make use of the <i>Di_Map_Annotation</i> parser to retrieve a map ...
            </p>
        </li>
        <li>
            <p>
            The <i>4th</i> way is using <span>Di</span> with Typehint based dependency maps. You only need to define the correct typehints within your classes and the <i>Di_Map_Typehint</i> parser does all the work for you.
            </p>
        </li>
    </ol>


    <a name="Demonstration"></a>
  <h3>Demonstration</h3>
    You will find detailed demonstrations (and the corresponding sourcecode) in the folder <a href="/" target="_blank">./_demo/</a>.<br />
    This should give you a good overview of what is possible with <span>Di</span> and what is (currently) not. For example how to inject dependencies using a ...
    <ul>
        <li>
            <a href="demonstration-static-1.php"><i><b>static</b> dependency map</i> (JSON format) and <i>manually wiring</i></a>
        </li>
        <li>
            <a href="demonstration-static-2.php"><i><b>static</b> dependency map</i> (JSON format) and <i>automagic wiring</i></a>
        </li>
        <li>
            <a href="demonstration-static-3.php"><i><b>static</b> dependency map</i> (JSON format) and a class with singleton pattern</a>
        </li>
        <li>
            <a href="demonstration-static-4.php"><i><b>static</b> dependency map</i> (JSON format) and using frozen objects so we don't need to wire</a>
        </li>
        <li>
            <a href="demonstration-static-5.php"><i><b>static</b> dependency map</i> (JSON format) Export an existing Di_Collection (from any Di_Map instance) to a static map and freeze instances</a>
        </li>
        <li>
            <a href="demonstration-fluent-1.php"><i><b>dynamic</b> dependency map</i> (fluent Interface) and <i>manually wiring</i></a>
        </li>
        <li>
            <a href="demonstration-fluent-2.php"><i><b>dynamic</b> dependency map</i> (fluent Interface) and <i>automagic wiring</i></a>
        </li>
        <li>
            <a href="demonstration-fluent-3.php"><i><b>dynamic</b> dependency map</i> (fluent Interface) and a class with singleton pattern</a>
        </li>
        <li>
            <a href="demonstration-fluent-4.php"><i><b>dynamic</b> dependency map</i> (fluent Interface), <i>automagic wiring</i> and <i>export to static dependency map (JSON format)</i></a>
        </li>
        <li>
            <a href="demonstration-annotation-1.php"><i><b>annotation</b> dependency map</i> (annotations inline) and <i>manually wiring</i></a>
        </li>
        <li>
            <a href="demonstration-annotation-2.php"><i><b>annotation</b> dependency map</i> (annotations inline) and <i>automagic wiring</i></a>
        </li>
        <li>
            <a href="demonstration-annotation-3.php"><i><b>annotation</b> dependency map</i> (annotations inline) and a class with singleton pattern</a>
        </li>
        <li>
            <a href="demonstration-typehint-1.php"><i><b>typehint</b> dependency map</i> (plain vanilla PHP) and <i>manually wiring</i></a>
        </li>
        <li>
            <a href="demonstration-typehint-2.php"><i><b>typehint</b> dependency map</i> (plain vanilla PHP) and <i>automagic wiring</i></a>
        </li>
        <li>
            <a href="demonstration-typehint-3.php"><i><b>typehint</b> dependency map</i> (plain vanilla PHP) and a class with singleton pattern</a>
        </li>
    </ul>

  <h3>API Documentation</h3>
    The sourcecode is fully documented and you can find the documentation here <a href="../docs/html/" target="_blank">./_doc/html/</a>.

    <h3>Roadmap</h3>
    This is the current roadmap of new features:
    <ul>
        <li>
            <p><strike>Map-builder which takes a <a href="../docs/html/class_di___collection.html" target="_blank">Di_Collection</a> as input and creates (build/write) a <b>static</b> <i>dependency map</i> (e.g. in JSON-Format) of it</strike></p>
        </li>
        <li>
            <p><strike>Storing of required dependencies within the static dependency map (PHP Object Freezer <a href="https://github.com/sebastianbergmann/php-object-freezer" target="_blank">https://github.com/sebastianbergmann/php-object-freezer</a>)</strike></p>
        </li>
        <li>
            <p>Increasing code-coverage of the Unit-Tests from approximately 79% up to ~100% ;)</p>
        </li>
    </ul>

    <br />
    Benjamin Carl | PHPFl&uuml;sterer<br />
    Software-Architect<br />
    <br />
    Visit my Blog for the latest news - <a href="http://www.phpfluesterer.de/" target="_blank">www.phpfluesterer.de</a>
</div>

</body>
</html>