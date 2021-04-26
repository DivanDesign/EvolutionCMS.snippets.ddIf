<?php
/**
 * ddIf
 * @version 2.0 (2021-01-20)
 * 
 * @see README.md
 * 
 * @link https://code.divandesign.biz/modx/ddif
 * 
 * @copyright 2012–2021 DD Group {@link https://DivanDesign.biz }
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