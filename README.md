# (MODX)EvolutionCMS.snippets.ddIf

This snippet compares different values and returns required chunk or string.


## Requires

* PHP >= 5.6
* [(MODX)EvolutionCMS](https://github.com/evolution-cms/evolution) >= 1.1
* [(MODX)EvolutionCMS.libraries.ddTools](https://code.divandesign.ru/modx/ddtools) >= 0.60


## Installation


### Manually


#### 1. Elements → Snippets: Create a new snippet with the following data

1. Snippet name: `ddIf`.
2. Description: `<b>2.2</b> This snippet compares different values and returns required chunk or string.`.
3. Category: `Core`.
4. Parse DocBlock: `no`.
5. Snippet code (php): Insert content of the `ddIf_snippet.php` file from the archive.


#### 2. Elements → Manage Files

1. Create a new folder `assets/snippets/ddIf/`.
2. Extract the archive to the folder (except `ddIf_snippet.php`).


### Using [(MODX)EvolutionCMS.libraries.ddInstaller](https://github.com/DivanDesign/EvolutionCMS.libraries.ddInstaller)

Just run the following PHP code in your sources or [Console](https://github.com/vanchelo/MODX-Evolution-Ajax-Console):

```php
//Include (MODX)EvolutionCMS.libraries.ddInstaller
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddInstaller/require.php'
);

//Install (MODX)EvolutionCMS.snippets.ddIf
\DDInstaller::install([
	'url' => 'https://github.com/DivanDesign/EvolutionCMS.snippets.ddIf',
	'type' => 'snippet'
]);
```

* If `ddIf` is not exist on your site, `ddInstaller` will just install it.
* If `ddIf` is already exist on your site, `ddInstaller` will check it version and update it if needed.


## Parameters description

* `operand1`
	* Desctription: The first operand for comparing.  
		An empty unparsed placeholder (like `'[+somePlaceholder+]'`) will be interpretated as empty string (`''`).
	* Valid values: `string`
	* **Required**
	
* `operand2`
	* Desctription: The second operand for comparing.
	* Valid values: `string`
	* Default value: `''`
	
* `operator`
	* Desctription: Comparing operator.  
		Values are case insensitive (the following names are equal: `'isNumeric'`, `'isnumeric'`, `'ISNUMERIC'`, etc).
	* Valid values:
		* `'=='`
		* `'!='`
		* `'>'`
		* `'<'`
		* `'<='`
		* `'>='`
		* `'bool'`
		* `'inArray'`
		* `'isNumeric'`
		* `'isWhitespace'` — checks if `operand1` is just white space (an empty string is also considered as white space)
		* `'isIncludes'` — case-sensitive check if `operand1` contains `operand2`
	* Default value: `'=='`
	
* `trueChunk`
	* Desctription: This value is returning if result is true.
		Available placeholders:
		* `[+snippetParams.operand1+]` — contains `operand1` value.
		* `[+snippetParams.operand2+]` — contains `operand2` value.
		* `[+snippetParams.operator+]` — contains `operator` value.
		* `[+`any placeholders from the `placeholders` parameter`+]`
	* Valid values:
		* `stringChunkName`
		* `string` — use inline templates starting with `@CODE:`
	* Default value: `''`
	
* `falseChunk`
	* Desctription: This value is returning if result is false. 
		Available placeholders:
		* `[+snippetParams.operand1+]` — contains `operand1` value.
		* `[+snippetParams.operand2+]` — contains `operand2` value.
		* `[+snippetParams.operator+]` — contains `operator` value.
		* `[+`any placeholders from the `placeholders` parameter`+]`
	* Valid values:
		* `stringChunkName`
		* `string` — use inline templates starting with `@CODE:`
	* Default value: `''`
	
* `placeholders`
	* Desctription:
		Additional data has to be passed into the `trueChunk` and `falseChunk`.  
		Nested objects and arrays are supported too:
		* `{"someOne": "1", "someTwo": "test" }` => `[+someOne+], [+someTwo+]`.
		* `{"some": {"a": "one", "b": "two"} }` => `[+some.a+]`, `[+some.b+]`.
		* `{"some": ["one", "two"] }` => `[+some.0+]`, `[+some.1+]`.
	* Valid values:
		* `stringJsonObject` — as [JSON](https://en.wikipedia.org/wiki/JSON)
		* `stringHjsonObject` — as [HJSON](https://hjson.github.io/)
		* `stringQueryFormatted` — as [Query string](https://en.wikipedia.org/wiki/Query_string)
		* It can also be set as a native PHP object or array (e. g. for calls through `$modx->runSnippet`):
			* `arrayAssociative`
			* `object`
	* Default value: —
	
* `debugTitle`
	* Desctription: The title for the System Event log if debugging is needed.  
		Just set it and watch the System Event log.
	* Valid values: `string`
	* Default value: —


## Examples


### String comparison

```
[[ddIf?
	&operand1=`Test string 1`
	&operator=`==`
	&operand2=`Test string 2`
	&trueChunk=`@CODE:The strings are equal.`
	&falseChunk=`@CODE:The strings are not equal.`
]]
```

Returns:

```
The strings are not equal.
```


### Checks if a value exists in an array

```
[[ddIf?
	&operand1=`Apple`
	&operator=`inArray`
	&operand2=`Pear,Banana,Apple,Orange`
	&trueChunk=`@CODE:Exists.`
	&falseChunk=`@CODE:Not exists.`
]]
```

Returns:

```
Exists.
```


### Check if `operand1` contains `operand2`

```
[[ddIf?
	&operand1=`The quick brown fox jumps over the lazy dog.`
	&operator=`isIncludes`
	&operand2=`fox`
	&trueChunk=`@CODE:“fox” is found`
	&falseChunk=`@CODE:“fox” is not found`
]]
```

Returns:

```
“fox” is found
```


### Checks if a `operand1` value is number or not

```
[[ddIf?
	&operand1=`123`
	&operator=`isNumeric`
	&trueChunk=`@CODE:Number.`
	&falseChunk=`@CODE:Not number.`
]]
```

Returns:

```
Number.
```


### Checks if a `operand1` value is just white space or not

Any number of spaces / tabs / new lines / etc are considered as white space.
An empty string is also considered as white space.

```
[[ddIf?
	&operand1=`
		 
	   
	    
	`
	&operator=`isWhitespace`
	&trueChunk=`@CODE:The string contains only some whitespace characters.`
	&falseChunk=`@CODE:[+snippetParams.operand1+]`
]]
```

Returns:

```
The string contains only some whitespace characters.
```

If `operand1` contains any non-whitespace characters, `falseString` will be returned.

```
[[ddIf?
	&operand1=`All you need is love.`
	&operator=`isWhitespace`
	&trueChunk=`@CODE:The string contains only some whitespace characters.`
	&falseChunk=`@CODE:[+snippetParams.operand1+]`
]]
```

Returns:

```
All you need is love.
```


### Number comparison and pass additional data to chunks

```
[[ddIf?
	&operand1=`[*general_price*]`
	&operator=`<`
	&operand2=`500`
	&trueChunk=`general_goodInexpensive`
	&falseChunk=`general_good`
	&placeholders=`{
		"title": "[*pagetitle*]",
		"image": "[*general_image*]",
		"somethingText": "All we need is love!"
	}`
]]
```

Code of the `general_good` chunk:

```html
<div>
	<h2>[+title+], $[+snippetParams.operand1+]</h2>
	<img src="[+image+]" alt="[+title+]" />
</div>
```

Code of the `general_goodInexpensive` chunk:

```html
<div class="inexpensive">
	<h2>[+title+], <strong>$[+snippetParams.operand1+]</strong></h2>
	<img src="[+image+]" alt="[+title+]" />
	<p>[+somethingText+]</p>
</div>
```

Let `[*general_price*]` be equal to `120`, then the snippet returns:

```html
<div class="inexpensive">
	<h2>Some inexpensive good, <strong>$120</strong></h2>
	<img src="assets/images/goods/some1.jpg" alt="Some inexpensive good" />
</div>
```


### Run the snippet through `\DDTools\Snippet::runSnippet` without DB and eval

```php
//Include (MODX)EvolutionCMS.libraries.ddTools
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddTools/modx.ddtools.class.php'
);

//Run (MODX)EvolutionCMS.snippets.ddIf
\DDTools\Snippet::runSnippet([
	'name' => 'ddIf',
	'params' => [
		'operand1' => '1',
		'operator' => 'bool',
		'trueChunk' => '@CODE:It's true!'
	]
]);
```


## Links

* [Home page](https://code.divandesign.ru/modx/ddif)
* [Telegram chat](https://t.me/dd_code)
* [Packagist](https://packagist.org/packages/dd/evolutioncms-snippets-ddif)
* [GitHub](https://github.com/DivanDesign/EvolutionCMS.snippets.ddIf)


<link rel="stylesheet" type="text/css" href="https://raw.githack.com/DivanDesign/CSS.ddMarkdown/master/style.min.css" />