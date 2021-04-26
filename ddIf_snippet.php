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

global $modx;

//# Include
//Include (MODX)EvolutionCMS.libraries.ddTools
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddTools/modx.ddtools.class.php'
);


//# Prepare params
$params = \DDTools\ObjectTools::extend([
	'objects' => [
		//Defaults
		(object) [
			//Required
			'operand1' => NULL,
			//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
			'operand2' => '',
			'operator' => '==',
			'trueChunk' => '',
			'falseChunk' => '',
			'placeholders' => [],
			//Unset
			'debugTitle' => NULL
		],
		$params
	]
]);

$params->operator =	mb_strtolower($params->operator);

//Разбиваем дополнительные данные
$params->placeholders = \ddTools::encodedStringToArray($params->placeholders);


//# Run
//The snippet must return an empty string even if result is absent
$snippetResult = '';

//Если передано, что сравнивать
if (!is_null($params->operand1)){
	//Если это сырой плейсхолдер, то скорее всего он пустой, и его не обработал парсер, приравняем тогда параметр к пустоте
	if(
		mb_substr(
			$params->operand1,
			0,
			2
		) == '[+' &&
		mb_substr(
			$params->operand1,
			-2
		) == '+]'
	){
		$params->operand1 = '';
	}
	
	//Булевое значение истинности сравнения
	$boolOut = '';
	
	//Выбираем сравнение в зависимости от оператора
	switch ($params->operator){
		case '!=':
		//Backward compatibility
		case '!r':
			$boolOut =
				$params->operand1 != $params->operand2 ?
				true :
				false
			;
		break;
		
		case '>':
		case 'b':
			$boolOut =
				$params->operand1 > $params->operand2 ?
				true :
				false
			;
		break;
		
		case '<':
		case 'm':
			$boolOut =
				$params->operand1 < $params->operand2 ?
				true :
				false
			;
		break;
		
		case '>=':
		case 'br':
			$boolOut =
				$params->operand1 >= $params->operand2 ?
				true :
				false
			;
		break;
		
		case '<=':
		case 'mr':
			$boolOut =
				$params->operand1 <= $params->operand2 ?
				true :
				false
			;
		break;
		
		case 'bool':
			$boolOut =
				$params->operand1 ?
				true :
				false
			;
		break;
		
		case 'inarray':
			$operand2Array = explode(
				',',
				$params->operand2
			);
			
			$boolOut =
				in_array(
					$params->operand1,
					$operand2Array
				) ?
				true :
				false
			;
		break;
		
		case 'isnumeric':
			$boolOut = is_numeric($params->operand1);
		break;
		
		case '==':
		case 'r':
		default:
			$boolOut =
				$params->operand1 == $params->operand2 ?
				true :
				false
			;
	}
	
	//Select output chunk
	$resultChunk =
		$boolOut ?
		$params->trueChunk :
		$params->falseChunk
	;
	
	//$modx->getTpl('@CODE:') returns '@CODE:' O_o
	$resultChunk = 
		$resultChunk == '@CODE:' ?
		'' :
		$modx->getTpl($resultChunk)
	;
	
	$snippetResult = \ddTools::parseText([
		'text' => $resultChunk,
		'data' => \DDTools\ObjectTools::extend([
			'objects' => [
				[
					'snippetParams.operand1' => $params->operand1,
					'snippetParams.operand2' => $params->operand2,
					'snippetParams.operator' => $params->operator
				],
				$params->placeholders
			]
		])
	]);
}

//Если для отладки нужно вывести то что пришло в сниппет выводим
if(!is_null($params->debugTitle)){
	\ddTools::logEvent([
		'message' =>
			'<p>Snippet parameters:</p><pre><code>' .
			var_export(
				$params,
				true
			) .
			'</code></pre>' .
			'<p>Snippet result:</p><pre><code>' .
			var_export(
				$snippetResult,
				true
			) .
			'</code></pre>'
		,
		'source' =>
			'ddIf: ' .
			$params->debugTitle
	]);
}

return $snippetResult;
?>