# (MODX)EvolutionCMS.snippets.ddIf

Сравнивает значения и выводит необходимый чанк или строку.


## Использует

* PHP >= 5.6
* [(MODX)EvolutionCMS](https://github.com/evolution-cms/evolution) >= 1.1
* [(MODX)EvolutionCMS.libraries.ddTools](https://code.divandesign.biz/modx/ddtools) >= 0.49.1


## Документация


### Установка


#### Вручную


##### 1. Элементы → Сниппеты: Создайте новый сниппет со следующими параметрами

1. Название сниппета: `ddIf`.
2. Описание: `<b>2.2</b> Сравнивает значения и выводит необходимый чанк или строку.`.
3. Категория: `Core`.
4. Анализировать DocBlock: `no`.
5. Код сниппета (php): Вставьте содержимое файла `ddIf_snippet.php` из архива.


##### 2. Элементы → Управление файлами

1. Создайте новую папку `assets/snippets/ddIf/`.
2. Извлеките содержимое архива в неё (кроме файла `ddIf_snippet.php`).


#### Используя [(MODX)EvolutionCMS.libraries.ddInstaller](https://github.com/DivanDesign/EvolutionCMS.libraries.ddInstaller)

Просто вызовите следующий код в своих исходинках или модуле [Console](https://github.com/vanchelo/MODX-Evolution-Ajax-Console):

```php
//Подключение (MODX)EvolutionCMS.libraries.ddInstaller
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddInstaller/require.php'
);

//Установка (MODX)EvolutionCMS.snippets.ddIf
\DDInstaller::install([
	'url' => 'https://github.com/DivanDesign/EvolutionCMS.snippets.ddIf',
	'type' => 'snippet'
]);
```

* Если `ddIf` отсутствует на вашем сайте, `ddInstaller` просто установит его.
* Если `ddIf` уже есть на вашем сайте, `ddInstaller` проверит его версию и обновит, если нужно. 


### Описание параметров

* `operand1`
	* Описание: Первое значение для сравнения.  
		Пустой не отпаршенный плейсхолдер (как `'[+somePlaceholder+]'`) будет интерпретирован как пустая строка (`''`).
	* Допустимые значения: `string`
	* **Обязателен**
	
* `operand2`
	* Описание: Второе значение для сравнения.
	* Допустимые значения: `string`
	* Значение по умолчанию: `''`
	
* `operator`
	* Описание: Оператор сравнения.  
		Значения регистронезависимы (следующие значения равны: `'isNumeric'`, `'isnumeric'`, `'ISNUMERIC'` и т. п.).
	* Допустимые значения:
		* `'=='`
		* `'!='`
		* `'>'`
		* `'<'`
		* `'<='`
		* `'>='`
		* `'bool'`
		* `'inArray'`
		* `'isNumeric'`
		* `'isWhitespace'` — проверяет, что строка `operand1` содержит только пробельные символы (пустая строка также считается пробельным символом)
	* Значение по умолчанию: `'=='`
	
* `trueChunk`
	* Описание: Значение, возвращаемое при истинном условии.
		Доступные плейсхолдеры:
		* `[+snippetParams.operand1+]` — содержит значение `operand1`.
		* `[+snippetParams.operand2+]` — содержит значение `operand2`.
		* `[+snippetParams.operator+]` — содержит значение `operator`.
		* `[+`любой плейсхолдер из параметра `placeholders` `+]`
	* Допустимые значения:
		* `stringChunkName`
		* `string` — передавать код напрямую без чанка можно начиная значение с `@CODE:`
	* Значение по умолчанию: `''`
	
* `falseChunk`
	* Описание: Значение, возвращаемое при ложном условии. 
		Доступные плейсхолдеры:
		* `[+snippetParams.operand1+]` — содержит значение `operand1`.
		* `[+snippetParams.operand2+]` — содержит значение `operand2`.
		* `[+snippetParams.operator+]` — содержит значение `operator`.
		* `[+`любой плейсхолдер из параметра `placeholders` `+]`
	* Допустимые значения:
		* `stringChunkName`
		* `string` — передавать код напрямую без чанка можно начиная значение с `@CODE:`
	* Значение по умолчанию: `''`
	
* `placeholders`
	* Описание:
		Дополнительные данные, которые будут переданы в шаблоны `trueChunk` и `falseChunk`.  
		Вложенные объекты и массивы также поддерживаются:
		* `{"someOne": "1", "someTwo": "test" }` => `[+someOne+], [+someTwo+]`.
		* `{"some": {"a": "one", "b": "two"} }` => `[+some.a+]`, `[+some.b+]`.
		* `{"some": ["one", "two"] }` => `[+some.0+]`, `[+some.1+]`.
	* Допустимые значения:
		* `stringJsonObject` — в виде [JSON](https://ru.wikipedia.org/wiki/JSON)
		* `stringHjsonObject` — в виде [HJSON](https://hjson.github.io/)
		* `stringQueryFormated` — в виде [Query string](https://en.wikipedia.org/wiki/Query_string)
		* Также может быть задан, как нативный PHP объект или массив (например, для вызовов через `$modx->runSnippet`).
			* `arrayAssociative`
			* `object`
	* Значение по умолчанию: —
	
* `debugTitle`
	* Описание: Заголовок для Протокола событий CMS.  
		Если нужно подебажить — задайте его и смотрите Протокол событий CMS.
	* Допустимые значения: `string`
	* Значение по умолчанию: —


### Примеры


#### Сравнение двух строк

```
[[ddIf?
	&operand1=`Тестовая строка 1`
	&operator=`==`
	&operand2=`Тестовая строка 2`
	&trueChunk=`@CODE:Строки равны.`
	&falseChunk=`@CODE:Строки не равны.`
]]
```

Вернёт:

```
Строки не равны.
```


#### Присутствует ли значение в массиве

```
[[ddIf?
	&operand1=`Яблоки`
	&operator=`inArray`
	&operand2=`Груши,Бананы,Яблоки,Апельсины`
	&trueChunk=`@CODE:Присутствует.`
	&falseChunk=`@CODE:Отсутствует.`
]]
```

Вернёт:

```
Присутствует.
```


#### Является ли `operand1` числом

```
[[ddIf?
	&operand1=`123`
	&operator=`isNumeric`
	&trueChunk=`@CODE:Число.`
	&falseChunk=`@CODE:Не число.`
]]
```

Вернёт:

```
Число.
```


#### Содержит ли `operand1` что-то, кроме пробельных символов

Любое количество пробелов / табуляторов / новых строк / etc трактуются пробельными.
Пустая строка также считается пробельным символом.

```
[[ddIf?
	&operand1=`
		 
	   
	    
	`
	&operator=`isWhitespace`
	&trueChunk=`@CODE:Строка содержит только пробельные символы.`
	&falseChunk=`@CODE:[+snippetParams.operand1+]`
]]
```

Вернёт:

```
Строка содержит только пробельные символы.
```

Если `operand1` содержит какие-либо непробельные символы, сниппет вернёт `falseString`.

```
[[ddIf?
	&operand1=`All you need is love.`
	&operator=`isWhitespace`
	&trueChunk=`@CODE:Строка содержит только пробельные символы.`
	&falseChunk=`@CODE:[+snippetParams.operand1+]`
]]
```

Вернёт:

```
All you need is love.
```


#### Сравнение двух чисел и передача дополнительных данных в чанки

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
		"somethingText": "Любовь — всё, что нам нужно!"
	}`
]]
```

Код чанка `general_good`:

```html
<div>
	<h2>[+title+], $[+snippetParams.operand1+]</h2>
	<img src="[+image+]" alt="[+title+]" />
</div>
```

Код чанка `general_goodInexpensive`:

```html
<div class="inexpensive">
	<h2>[+title+], <strong>$[+snippetParams.operand1+]</strong></h2>
	<img src="[+image+]" alt="[+title+]" />
	<p>[+somethingText+]</p>
</div>
```

Пусть `[*general_price*]` равно `120`, тогда сниппет вернёт:

```html
<div class="inexpensive">
	<h2>Один из недорогих товаров, <strong>$120</strong></h2>
	<img src="assets/images/goods/some1.jpg" alt="Один из недорогих товаров" />
</div>
```


#### Запустить сниппет через `\DDTools\Snippet::runSnippet` без DB и eval

```php
//Подключение (MODX)EvolutionCMS.libraries.ddTools
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddTools/modx.ddtools.class.php'
);

//Запуск (MODX)EvolutionCMS.snippets.ddIf
\DDTools\Snippet::runSnippet([
	'name' => 'ddIf',
	'params' => [
		'operand1' => '1',
		'operator' => 'bool',
		'trueChunk' => '@CODE:Это истина!'
	]
]);
```


## Ссылки

* [Home page](https://code.divandesign.ru/modx/ddif)
* [Telegram chat](https://t.me/dd_code)
* [Packagist](https://packagist.org/packages/dd/evolutioncms-snippets-ddif)


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />