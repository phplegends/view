## Table of contents

- [\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)
- [\PHPLegends\Legendary\View](#class-phplegendslegendaryview)
- [\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)
- [\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)
- [\PHPLegends\Legendary\Factory](#class-phplegendslegendaryfactory)
- [\PHPLegends\Legendary\Engine\Interpreter](#class-phplegendslegendaryengineinterpreter)
- [\PHPLegends\Legendary\Engine\Compiler](#class-phplegendslegendaryenginecompiler)
- [\PHPLegends\Legendary\Engine\SubExpression](#class-phplegendslegendaryenginesubexpression)
- [\PHPLegends\Legendary\Engine\Expression](#class-phplegendslegendaryengineexpression)

<hr /> 
### Class: \PHPLegends\Legendary\SectionCollection

| Visibility | Function |
|:-----------|:---------|
| public | <strong>attach(</strong><em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em> <strong>$section</strong>)</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>Attaches the section in current collection</em> |
| public | <strong>clear()</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>Erases the collection</em> |
| public | <strong>detach(</strong><em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em> <strong>$section</strong>)</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>Detaches the section from current collection</em> |
| public | <strong>detachByName(</strong><em>mixed</em> <strong>$name</strong>)</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>Detaches the section by name from current collection</em> |
| public | <strong>find(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)/false</em> |
| public | <strong>findOrCreate(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em> |
| public | <strong>getIterator()</strong> : <em>\ArrayIterator</em><br /><em>Implementation for \IteratorAggregate</em> |
| public | <strong>last()</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>returns the last section of current collection</em> |
| public | <strong>pop(</strong><em>mixed</em> <strong>$name=null</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em><br /><em>Remove the last element of collection or given name passed by argument</em> |

*This class implements \IteratorAggregate, \Traversable*

<hr /> 
### Class: \PHPLegends\Legendary\View

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>mixed</em> <strong>$name</strong>, <em>array</em> <strong>$data=array()</strong>, <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em> <strong>$config=null</strong>)</strong> : <em>void</em> |
| public | <strong>__toString()</strong> : <em>string</em><br /><em>returns strings using the method static::render()</em> |
| public | <strong>appendSection()</strong> : <em>void</em><br /><em>Appends output buffer in a existing section</em> |
| public static | <strong>config(</strong><em>mixed</em> <strong>$config</strong>)</strong> : <em>void</em> |
| public static | <strong>create(</strong><em>string</em> <strong>$name</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>\PHPLegends\Legendary\static</em><br /><em>Easy way to make a view with factory config</em> |
| public | <strong>endSection()</strong> : <em>void</em><br /><em>Ends a section</em> |
| public | <strong>extend(</strong><em>string</em> <strong>$name</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>void</em><br /><em>Extends the current view with a parent view. The data too is shared.</em> |
| public | <strong>getConfig()</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Return configuration of view</em> |
| public | <strong>getData()</strong> : <em>array</em><br /><em>Get data passed to view</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Get filename used by current view</em> |
| public | <strong>getSection(</strong><em>string</em> <strong>$name</strong>, <em>string</em> <strong>$default=`''`</strong>)</strong> : <em>string</em><br /><em>Gives the value of a initialized section</em> |
| public | <strong>getSectionsCollection()</strong> : <em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em><br /><em>Gets the collection of sections</em> |
| public | <strong>handleException(</strong><em>\Exception</em> <strong>$exception</strong>)</strong> : <em>void</em><br /><em>Handles the Exception</em> |
| public | <strong>render()</strong> : <em>string</em><br /><em>Get view renderized</em> |
| public | <strong>setConfig(</strong><em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em> <strong>$config</strong>)</strong> : <em>[\PHPLegends\Legendary\View](#class-phplegendslegendaryview)</em><br /><em>Set a configuration for view</em> |
| public | <strong>setData(</strong><em>array</em> <strong>$array</strong>)</strong> : <em>[\PHPLegends\Legendary\View](#class-phplegendslegendaryview)</em><br /><em>Merges data to current data in view</em> |
| public | <strong>setName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>[\PHPLegends\Legendary\View](#class-phplegendslegendaryview)</em><br /><em>Set filename for view</em> |
| public | <strong>setSectionsCollection(</strong><em>[\PHPLegends\Legendary\SectionCollection](#class-phplegendslegendarysectioncollection)</em> <strong>$sections</strong>)</strong> : <em>void</em><br /><em>Sets a new collection of section in current view</em> |
| public | <strong>startSection(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em><br /><em>Starts a section</em> |

<hr /> 
### Class: \PHPLegends\Legendary\ViewConfig

| Visibility | Function |
|:-----------|:---------|
| public | <strong>cacheEnabled()</strong> : <em>bool</em><br /><em>Cache is enabled?</em> |
| public | <strong>findView(</strong><em>string</em> <strong>$view</strong>)</strong> : <em>string The string path</em><br /><em>Finds view by  name and namespace definitions. If the view Legendary is not found, the next search will be made for a php view.</em> |
| public | <strong>getTemporaryDirectory()</strong> : <em>string</em><br /><em>Retrieves name of temporary directory used by compiler</em> |
| public | <strong>namespaceExists(</strong><em>string</em> <strong>$namespace</strong>)</strong> : <em>bool</em><br /><em>Create namespace</em> |
| public | <strong>registerNamespace(</strong><em>string</em> <strong>$namespace</strong>, <em>string</em> <strong>$directory</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Registrer an namespace for a directory of views</em> |
| public | <strong>registerNamespaces(</strong><em>array</em> <strong>$namespaces</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Registre a group of namespaces by array</em> |
| public | <strong>setLegendaryExtension(</strong><em>string</em> <strong>$extension</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Defines the extension of legendary view</em> |
| public | <strong>setPHPExtension(</strong><em>string</em> <strong>$extension</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Defines the extension of php view</em> |
| public | <strong>setTemporaryDirectory(</strong><em>string</em> <strong>$tempDir</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Defines the temporary directory</em> |
| public | <strong>setViewPath(</strong><em>string</em> <strong>$viewPath</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Defines the path of view</em> |
| public | <strong>usesCache(</strong><em>mixed</em> <strong>$cacheEnabled</strong>)</strong> : <em>[\PHPLegends\Legendary\ViewConfig](#class-phplegendslegendaryviewconfig)</em><br /><em>Defines if compiler will use cache or not</em> |
| protected | <strong>buildViewPath(</strong><em>mixed/string/null</em> <strong>$view=null</strong>)</strong> : <em>string</em><br /><em>Builds the name of view path</em> |
| protected | <strong>parseViewName(</strong><em>mixed</em> <strong>$view</strong>)</strong> : <em>string</em><br /><em>Parse view name to given fullpath of a view</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Section

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>void</em> |
| public | <strong>__toString()</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em><br /><em>Returns the static::getContents()</em> |
| public | <strong>append()</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em><br /><em>Append output buffer in current section</em> |
| public | <strong>appendContent(</strong><em>string</em> <strong>$content</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em><br /><em>Appends string in current section</em> |
| public | <strong>end()</strong> : <em>void</em><br /><em>Close the output buffer capturing</em> |
| public | <strong>getContent()</strong> : <em>string</em><br /><em>Returns the content of current section</em> |
| public | <strong>getName()</strong> : <em>string</em><br /><em>Returns the name of section</em> |
| public | <strong>setContent(</strong><em>string</em> <strong>$content</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em> |
| public | <strong>setName(</strong><em>string</em> <strong>$name</strong>)</strong> : <em>[\PHPLegends\Legendary\Section](#class-phplegendslegendarysection)</em><br /><em>Defines the name of section</em> |
| public | <strong>start()</strong> : <em>void</em><br /><em>Starts the output buffer capturing in current section]</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Factory

> Factory to make view * @author Wallace de Souza Vizerra <wallacemaxters@gmail.com>

| Visibility | Function |
|:-----------|:---------|
| public static | <strong>loadConfig(</strong><em>array</em> <strong>$config</strong>)</strong> : <em>void</em><br /><em>Create ViewConfig instance from array</em> |
| public static | <strong>loadConfigFile(</strong><em>string</em> <strong>$filename</strong>)</strong> : <em>void</em><br /><em>Load config file to create a config</em> |
| public static | <strong>view(</strong><em>mixed</em> <strong>$viewName</strong>, <em>array</em> <strong>$data=array()</strong>)</strong> : <em>[\PHPLegends\Legendary\View](#class-phplegendslegendaryview)</em><br /><em>Create a view</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Engine\Interpreter

> The interpreter@author Wallace de Souza Vizerra <wallacemaxters@gmail.com>

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct()</strong> : <em>void</em> |
| public | <strong>compile(</strong><em>string</em> <strong>$source</strong>)</strong> : <em>string</em><br /><em>Gives the compiled output</em> |
| public | <strong>saveCompiled(</strong><em>string</em> <strong>$fileOutput</strong>, <em>string</em> <strong>$source</strong>)</strong> : <em>\SplFileObject</em><br /><em>Save compile output in a new file</em> |
| public | <strong>setEchoEntities(</strong><em>string</em> <strong>$start</strong>, <em>string</em> <strong>$end</strong>)</strong> : <em>[\PHPLegends\Legendary\Engine\Interpreter](#class-phplegendslegendaryengineinterpreter)</em> |
| public | <strong>setEspacedEchoEntities(</strong><em>string</em> <strong>$start</strong>, <em>string</em> <strong>$end</strong>)</strong> : <em>[\PHPLegends\Legendary\Engine\Interpreter](#class-phplegendslegendaryengineinterpreter)</em> |
| public | <strong>setExpressionEntities(</strong><em>string</em> <strong>$start</strong>, <em>string</em> <strong>$end</strong>)</strong> : <em>[\PHPLegends\Legendary\Engine\Interpreter](#class-phplegendslegendaryengineinterpreter)</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Engine\Compiler

> The compiler@author Wallace de Souza Vizerra <wallacemaxters@gmail.com>

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$filename</strong>)</strong> : <em>void</em> |
| public | <strong>getCompiledCache(</strong><em>string</em> <strong>$outputFile</strong>)</strong> : <em>\SplfFileObject</em><br /><em>Gives a compiled file or cached compiled file</em> |
| public | <strong>isExpiredCache(</strong><em>mixed</em> <strong>$outputFile</strong>)</strong> : <em>bool</em><br /><em>Check if cache has expired</em> |
| public | <strong>save(</strong><em>string</em> <strong>$outputFile</strong>, <em>bool</em> <strong>$cache=true</strong>)</strong> : <em>\SplfFileObject</em><br /><em>Easy way to save compiled with cached or not</em> |
| public | <strong>saveCompiled(</strong><em>string</em> <strong>$outputFile</strong>)</strong> : <em>\SplfFileObject</em><br /><em>Save compiled code from parsed file</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Engine\SubExpression

> The Subexpression to be used in Expression class as complement@author Wallace de Souza Vizerra <wallacemaxters@gmail.com>

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$expression=`'{all}'`</strong>, <em>string</em> <strong>$replacement=`'$1'`</strong>)</strong> : <em>void</em> |
| public | <strong>__toString()</strong> : <em>string</em><br /><em>To string implementation returns static::getSubRegexp()</em> |
| public | <strong>getReplacement()</strong> : <em>string</em><br /><em>Gives the replacement of the subexpression</em> |
| public | <strong>getSubRegexp()</strong> : <em>string</em><br /><em>Get the regexp part for subexpression</em> |

<hr /> 
### Class: \PHPLegends\Legendary\Engine\Expression

> The Expression used for compiler@author Wallace de Souza Vizerra <wallacemaxters@gmail.com>

| Visibility | Function |
|:-----------|:---------|
| public | <strong>__construct(</strong><em>string</em> <strong>$start</strong>, <em>string</em> <strong>$end</strong>, <em>string</em> <strong>$replacement</strong>)</strong> : <em>void</em><br /><em>Create a delimiter expression for compiles into php</em> |
| public | <strong>buildRegexp(</strong><em>[\PHPLegends\Legendary\Engine\SubExpression](#class-phplegendslegendaryenginesubexpression)</em> <strong>$subexpression</strong>)</strong> : <em>string</em><br /><em>builds a regexp with union of expression and subexpression</em> |
| public | <strong>compile(</strong><em>[\PHPLegends\Legendary\Engine\SubExpression](#class-phplegendslegendaryenginesubexpression)</em> <strong>$subexpression</strong>, <em>string</em> <strong>$subject</strong>)</strong> : <em>string</em><br /><em>Compile subexpression merging data in this expression</em> |
| public | <strong>getReplacement(</strong><em>[\PHPLegends\Legendary\Engine\SubExpression](#class-phplegendslegendaryenginesubexpression)</em> <strong>$expression</strong>)</strong> : <em>string</em><br /><em>Gets replacement of this and subexpression combined</em> |

