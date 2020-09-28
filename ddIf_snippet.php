<?php
/**
 * ddIf
 * @version 1.7 (2020-09-28)
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

//Если для отладки нужно вывести то что пришло в сниппет выводим
if(isset($debugTitle)){
	\ddTools::logEvent([
		'message' =>
			'<p>Snippet parameters:</p><code><pre>' .
			var_export(
				$params,
				true
			) .
			'</pre></code>'
		,
		'source' =>
			'ddIf: ' .
			$debugTitle
	]);
}

//Если передано, что сравнивать
if (isset($operand1)){
	//Если это сырой плейсхолдер, то скорее всего он пустой, и его не обработал парсер, приравняем тогда параметр к пустоте
	if(
		mb_substr(
			$operand1,
			0,
			2
		) == '[+'
	){
		$operand1 = '';
	}
	
	//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
	$operand2 =
		isset($operand2) ?
		$operand2 :
		''
	;
	$operator =
		isset($operator) ?
		mb_strtolower($operator) :
		'=='
	;
	
	//Булевое значение истинности сравнения
	$boolOut = '';
	
	//Выбираем сравнение в зависимости от оператора
	switch ($operator){
		case '!=':
		//Backward compatibility
		case '!r':
			$boolOut =
				$operand1 != $operand2 ?
				true :
				false
			;
		break;
		
		case '>':
		case 'b':
			$boolOut =
				$operand1 > $operand2 ?
				true :
				false
			;
		break;
		
		case '<':
		case 'm':
			$boolOut =
				$operand1 < $operand2 ?
				true :
				false
			;
		break;
		
		case '>=':
		case 'br':
			$boolOut =
				$operand1 >= $operand2 ?
				true :
				false
			;
		break;
		
		case '<=':
		case 'mr':
			$boolOut =
				$operand1 <= $operand2 ?
				true :
				false
			;
		break;
		
		case 'bool':
			$boolOut =
				$operand1 ?
				true :
				false
			;
		break;
		
		case 'inarray':
			$operand2Array = explode(
				',',
				$operand2
			);
			
			$boolOut =
				in_array(
					$operand1,
					$operand2Array
				) ?
				true :
				false
			;
		break;
		
		case 'isnumeric':
			$boolOut = is_numeric($operand1);
		break;
		
		case '==':
		case 'r':
		default:
			$boolOut =
				$operand1 == $operand2 ?
				true :
				false
			;
	}
	
	//Если есть дополнительные данные
	if (isset($placeholders)){
		//Разбиваем их
		$placeholders = \ddTools::encodedStringToArray($placeholders);
	}else{
		$placeholders = [];
	}
	
	//Backward compatibility
	if (
		isset($trueString) ||
		isset($falseString)
	){
		\ddTools::logEvent([
			'message' => '<p>The “trueString” and “falseString” parameters are deprecated. Please use instead “trueChunk” and “falseChunk” with the “@CODE:” prefix.</p>'
		]);
		
		if (isset($trueString)){
			$trueChunk =
				'@CODE:' .
				$trueString
			;
		}
		
		if (isset($falseString)){
			$falseChunk =
				'@CODE:' .
				$falseString
			;
		}
	}
	
	//Select output chunk
	$resultChunk =
		$boolOut ?
		(
			isset($trueChunk) ?
			$trueChunk :
			''
		) :
		(
			isset($falseChunk) ?
			$falseChunk :
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
				'ddIf_operand1' => $operand1,
				'ddIf_operand2' => $operand2,
				'ddIf_operator' => $operator
			],
			$placeholders
		)
	]);
}

return $snippetResult;
?>