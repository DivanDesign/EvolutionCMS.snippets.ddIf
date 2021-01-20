# (MODX)EvolutionCMS.snippets.ddIf

This snippet compares different values and returns required chunk or string.


## Requires

* PHP >= 5.4
* [(MODX)EvolutionCMS](https://github.com/evolution-cms/evolution) >= 1.1
* [(MODX)EvolutionCMS.libraries.ddTools](https://code.divandesign.biz/modx/ddtools) >= 0.40.1 (not tested with older versions)


## Documentation


### Installation

Elements → Snippets: Create a new snippet with the following data:

1. Snippet name: `ddIf`.
2. Description: `<b>2.0</b> This snippet compares different values and returns required chunk or string.`.
3. Category: `Core`.
4. Parse DocBlock: `no`.
5. Snippet code (php): Insert content of the `ddIf_snippet.php` file from the archive.


### Parameters description

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
	* Valid values:
		* `'=='`
		* `'!='`
		* `'>'`
		* `'<'`
		* `'<='`
		* `'>='`
		* `'bool'`
		* `'inarray'`
		* `'isnumeric'`
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
		* `stringQueryFormated` — as [Query string](https://en.wikipedia.org/wiki/Query_string)
		* It can also be set as a PHP object or array (e. g. for calls through `$modx->runSnippet`).
			* `arrayAssociative`
			* `object`
	* Default value: —
	
* `debugTitle`
	* Desctription: The title for the System Event log if debugging is needed.  
		Just set it and watch the System Event log.
	* Valid values: `string`
	* Default value: —


### Examples


#### String comparison

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


#### Checks if a value exists in an array

```
[[ddIf?
	&operand1=`Apple`
	&operator=`inarray`
	&operand2=`Pear,Banana,Apple,Orange`
	&trueChunk=`@CODE:Exists.`
	&falseChunk=`@CODE:Not exists.`
]]
```

Returns:

```
Exists.
```


#### Checks if a `operand1` value is number or not

```
[[ddIf?
	&operand1=`123`
	&operator=`isnumeric`
	&trueChunk=`@CODE:Number.`
	&falseChunk=`@CODE:Not number.`
]]
```

Returns:

```
Number.
```


#### Number comparison and pass additional data to chunks

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


## Links

* [Home page](https://code.divandesign.biz/modx/ddif)
* [Telegram chat](https://t.me/dd_code)
* [Packagist](https://packagist.org/packages/dd/evolutioncms-snippets-ddif)


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />