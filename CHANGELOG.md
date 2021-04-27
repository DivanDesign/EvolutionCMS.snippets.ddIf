# (MODX)EvolutionCMS.snippets.ddIf changelog


## Version 2.1 (2021-04-27)
* \* Attention! PHP >= 5.6 is required.
* \* Attention! (MODX)EvolutionCMS.libraries.ddTools >= 0.49.1 is required.
* \+ Parameters → `placeholders`: Can also be set as [HJSON](https://hjson.github.io/).
* \+ You can just call `\DDTools\Snippet::runSnippet` to run the snippet without DB and eval (see README → Examples).
* \+ `\ddIf\Snippet`: The new class. All snippet code was moved here.
* \+ Composer.json → `support`.


## Version 2.0 (2021-01-20)
* \* Attention! Backward compatibility is broken.
* \- Parameters → `trueString`, `falseString`: The deprecated parameters are no longer supported.
* \* Parameters → `trueChunk`, `falseChunk`: The following available placeholders were renamed:
	* \* `ddIf_operand1` → `snippetParams.operand1`.
	* \* `ddIf_operand2` → `snippetParams.operand2`.
	* \* `ddIf_operator` → `snippetParams.operator`.
* \+ Snippet result was added to debug log message.
* \+ Improved style of debug log message.
* \* Refactoring:
	* \* The `$params` variable is used instead of a standalone variable for each parameter.
	* \* `\DDTools\ObjectTools::extend` is used to set parameters defaults.
* \+ README → Links → Packagist.


## Version 1.7.1 (2020-10-08)
* \* Parameters → `operand1`: Improved an empty unparsed placeholder recognition.


## Version 1.7 (2020-09-28)
* \* Attention! (MODX)Evolution.libraries.ddTools >= 0.40.1 is required (not tested with older versions).
* \+ Parameters → `placeholders`: Nested arrays are supported too.
* \+ README.
* \+ README_ru.
* \+ CHANGELOG.
* \+ CHANGELOG_ru.
* \+ Composer.json.


## Version 1.6 (2018-12-05)
* \+ Parameters → `trueChunk`, `falseChunk`: Added few placeholders:
	* \+ `[+ddIf_operand1+]` — contains `operand1` value.
	* \+ `[+ddIf_operand2+]` — contains `operand2` value.
	* \+ `[+ddIf_operator+]` — contains `operator` value.


## Version 1.5 (2018-10-31)
* \+ Parameters → `debugTitle`: The new parameter. If you need to debug just set it and watch the System Event log.
* \+ Parameters → `operand1`: If is equal to something like `[+somePlaceholder+]` the snippet interpretate it as `''`. It's convenient when placeholders were not parsed for any reason.


## Version 1.4 (2017-02-10)
* \* Attention! PHP >= 5.4 is required.
* \* Attention! (MODX)Evolution >= 1.1 is required.
* \* Attention! (MODX)Evolution.libraries.ddTools >= 0.18 is required.
* \+ Parameters → `placeholders`: Added JSON and Query string support. The old format is still supported but deprecated.
* \+ Parameters → `trueChunk`, `falseChunk`: Added support of the `@CODE:` keyword prefix.
* \- Parameters → `trueString`, `falseString`: Are deprecated (use `@CODE:` prefix instead). Backward compatibility is preserved with message to the CMS Event log.
* \* Small optimization and other changes.


## Version 1.3 (2016-07-14)
* \+ Parameter → `operator`:
	* \+ Now can be equal to `isnumeric` — check the `operand1` is number or not.
	* \+ Is not case sensitive.


## Version 1.2 (2015-02-22)
* \* Attention! (MODX)Evolution >= 1.0.13 is required.
* \+ Parameters → `operator`: Now can gets a simple operator value instead of it’s letter alias (of course, with backward compatibility).
* \+ Additional data (from the `placeholders` parameter) are processed in the `trueString` and `falseString` parameters too.
* \* Refactoring:
	* \* The `$result` variable has not been used for placeholders array anymore, the `$placeholder` variable instead.
	* \* One `return` instead of several, `return` in any case.


## Version 1.1 (2012-04-05)
* \* Attention! Backward compatibility is broken. Actually the version should be named as 2.0 because of backward compatibility absence but renaming hasn’t been done on account of minor changes.
* \* Attention! (MODX)Evolution.libraries.ddTools >= 0.2 is required.
* \* Parameters:
	* \* `operand1`: Has been renamed from `subject`.
	* \* `operand2`: Has been renamed from `operand`.
	* \* `trueChunk`: Has been renamed from `trueChank`.
	* \* `falseChunk`: Has been renamed from `falseChank`.


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />
<style>ul{list-style:none;}</style>