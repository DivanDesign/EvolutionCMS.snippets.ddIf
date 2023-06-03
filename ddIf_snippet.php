<?php
/**
 * ddIf
 * @version 2.2 (2021-04-30)
 * 
 * @see README.md
 * 
 * @link https://code.divandesign.ru/modx/ddif
 * 
 * @copyright 2012–2021 Ronef {@link https://Ronef.ru }
 */

//Include (MODX)EvolutionCMS.libraries.ddTools
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddTools/modx.ddtools.class.php'
);

return \DDTools\Snippet::runSnippet([
	'name' => 'ddIf',
	'params' => $params
]);
?>