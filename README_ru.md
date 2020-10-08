# (MODX)EvolutionCMS.snippets.ddIf

Сравнивает значения и выводит необходимый чанк или строку.


## Использует

* PHP >= 5.4
* [(MODX)EvolutionCMS](https://github.com/evolution-cms/evolution) >= 1.1
* [(MODX)EvolutionCMS.libraries.ddTools](https://code.divandesign.biz/modx/ddtools) >= 0.40.1 (не тестировался с более старыми версиями)


## Документация


### Установка

Элементы → Сниппеты: Создайте новый сниппет со следующими параметрами:

1. Название сниппета: `ddIf`.
2. Описание: `<b>1.7.1</b> Сравнивает значения и выводит необходимый чанк или строку.`.
3. Категория: `Core`.
4. Анализировать DocBlock: `no`.
5. Код сниппета (php): Вставьте содержимое файла `ddIf_snippet.php` из архива.


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
	* Допустимые значения:
		* `'=='`
		* `'!='`
		* `'>'`
		* `'<'`
		* `'<='`
		* `'>='`
		* `'bool'`
		* `'inarray'`
		* `'isnumeric'`
	* Значение по умолчанию: `'=='`
	
* `trueChunk`
	* Описание: Значение, возвращаемое при истинном условии.
		Доступные плейсхолдеры:
		* `[+ddIf_operand1+]` — содержит значение `operand1`.
		* `[+ddIf_operand2+]` — содержит значение `operand2`.
		* `[+ddIf_operator+]` — содержит значение `operator`.
		* `[+`любой плейсхолдер из параметра `placeholders` `+]`
	* Допустимые значения:
		* `stringChunkName`
		* `string` — передавать код напрямую без чанка можно начиная значение с `@CODE:`
	* Значение по умолчанию: `''`
	
* `falseChunk`
	* Описание: Значение, возвращаемое при ложном условии. 
		Доступные плейсхолдеры:
		* `[+ddIf_operand1+]` — содержит значение `operand1`.
		* `[+ddIf_operand2+]` — содержит значение `operand2`.
		* `[+ddIf_operator+]` — содержит значение `operator`.
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
	&operator=`inarray`
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
	&operator=`isnumeric`
	&trueChunk=`@CODE:Число.`
	&falseChunk=`@CODE:Не число.`
]]
```

Вернёт:

```
Число.
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
	<h2>[+title+], $[+ddIf_operand1+]</h2>
	<img src="[+image+]" alt="[+title+]" />
</div>
```

Код чанка `general_goodInexpensive`:

```html
<div class="inexpensive">
	<h2>[+title+], <strong>$[+ddIf_operand1+]</strong></h2>
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


## Ссылки

* [Home page](https://code.divandesign.ru/modx/ddif)
* [Telegram chat](https://t.me/dd_code)


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />