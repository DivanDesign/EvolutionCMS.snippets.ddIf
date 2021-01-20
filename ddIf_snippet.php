<?php
/**
 * ddIf
 * @version 1.7.1 (2020-10-08)
 * 
 * @see README.md
 * 
 * @link https://code.divandesign.biz/modx/ddif
 * 
 * @copyright 2012–2020 DD Group {@link https://DivanDesign.biz }
 */

global $modx;

//Include (MODX)EvolutionCMS.libraries.ddTools
require_once(
	$modx->getConfig('base_path') .
	'assets/libs/ddTools/modx.ddtools.class.php'
);

//The snippet must return an empty string even if result is absent
$snippetResult = '';

$params = \DDTools\ObjectTools::convertType([
	'object' => $params,
	'type' => 'objectStdClass'
]);

//Если передано, что сравнивать
if (isset($params->operand1)){
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
	
	//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
	$params->operand2 =
		isset($params->operand2) ?
		$params->operand2 :
		''
	;
	$params->operator =
		isset($params->operator) ?
		mb_strtolower($params->operator) :
		'=='
	;
	
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
	
	//Если есть дополнительные данные
	if (isset($params->placeholders)){
		//Разбиваем их
		$params->placeholders = \ddTools::encodedStringToArray($params->placeholders);
	}else{
		$params->placeholders = [];
	}
	
	//Backward compatibility
	if (
		isset($params->trueString) ||
		isset($params->falseString)
	){
		\ddTools::logEvent([
			'message' => '<p>The “trueString” and “falseString” parameters are deprecated. Please use instead “trueChunk” and “falseChunk” with the “@CODE:” prefix.</p>'
		]);
		
		if (isset($params->trueString)){
			$params->trueChunk =
				'@CODE:' .
				$params->trueString
			;
		}
		
		if (isset($params->falseString)){
			$params->falseChunk =
				'@CODE:' .
				$params->falseString
			;
		}
	}
	
	//Select output chunk
	$resultChunk =
		$boolOut ?
		(
			isset($params->trueChunk) ?
			$params->trueChunk :
			''
		) :
		(
			isset($params->falseChunk) ?
			$params->falseChunk :
			''
		)
	;
	
	//$modx->getTpl('@CODE:') returns '@CODE:' O_o
	$resultChunk = $modx->getTpl(
		$resultChunk != '@CODE:' ?
		$resultChunk :
		''
	);
	
	$snippetResult = \ddTools::parseText([
		'text' => $resultChunk,
		'data' => array_merge(
			[
				'ddIf_operand1' => $params->operand1,
				'ddIf_operand2' => $params->operand2,
				'ddIf_operator' => $params->operator
			],
			$params->placeholders
		)
	]);
}

//Если для отладки нужно вывести то что пришло в сниппет выводим
if(isset($params->debugTitle)){
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