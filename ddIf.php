<?php
/**
 * ddIf
 * @version 1.4 (2017-02-10)
 * 
 * @desc This snippet compares 2 values and returns required chunk or string.
 * 
 * @uses PHP >= 5.4.
 * @uses MODXEvo >= 1.1.
 * @uses MODXEvo.library.ddTools >= 0.18.
 * 
 * @param $operand1 {string} — The first operand for comparing. @required
 * @param $operand2 {string} — The second operand for comparing. Default: ''.
 * @param $operator {'=='|'!='|'>'|'<'|'<='|'>='|'bool'|'inarray'|'isnumeric'} — Comparing operator. Default: '=='.
 * @param $trueChunk {string_chunkName|string} — This value is returning if result is true (chunk name or code via “@CODE:” prefix). Default: ''.
 * @param $falseChunk {string_chunkName|string} — This value is returning if result is false (chunk name or code via “@CODE:” prefix). Default: ''.
 * @param $placeholders {string_json|string_queryFormated} — Additional data which is required to transfer to chunk. JSON or query-formated string, e. g.: '{"width": 800, "height": 600}' or 'width=800&height=600'. Default: ''.
 * @param $logTitle {string} — The title for log row for the debugging data.
 * 
 * @link http://code.divandesign.biz/modx/ddif/1.4
 * 
 * @copyright 2012–2017 DivanDesign {@link http://www.DivanDesign.biz }
 */

$result = '';

require_once $modx->getConfig('base_path').'assets/libs/ddTools/modx.ddtools.class.php';

//Если для отладки нужно вывести то что пришло в сниппет выводим
if(isset($logTitle)){
	ddTools::logEvent([
		'message' => '<code><pre>'.print_r(
			$params,
			true
		).'</pre></code>',
		'source' => 'ddIf — '.$logTitle
	]);
}

//Если передано, что сравнивать
if (isset($operand1)){
	//Если это сырой плейсхолдер, то скорее всего он пустой, и его не обработал парсер, приравняем тогда параметр к пустоте
	if(mb_substr(
		$operand1,
		0,
		2
	) == '[+'){
		$operand1 = '';
	}
	
	//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
	$operand2 = isset($operand2) ? $operand2 : '';
	$operator = isset($operator) ? mb_strtolower($operator) : '==';
	
	//Булевое значение истинности сравнения
	$boolOut = '';
	//Выбираем сравнение в зависимости от оператора
	switch ($operator){
		case '!=':
		//Backward compatibility
		case '!r':
			$boolOut = ($operand1 != $operand2) ? true : false;
		break;
		
		case '>':
		case 'b':
			$boolOut = ($operand1 > $operand2) ? true : false;
		break;
		
		case '<':
		case 'm':
			$boolOut = ($operand1 < $operand2) ? true : false;
		break;
		
		case '>=':
		case 'br':
			$boolOut = ($operand1 >= $operand2) ? true : false;
		break;
		
		case '<=':
		case 'mr':
			$boolOut = ($operand1 <= $operand2) ? true : false;
		break;
		
		case 'bool':
			$boolOut = ($operand1) ? true : false;
		break;
		
		case 'inarray':
			$operand2 = explode(
				',',
				$operand2
			);
			$boolOut = in_array(
				$operand1,
				$operand2
			) ? true : false;
		break;
		
		case 'isnumeric':
			$boolOut = is_numeric($operand1);
		break;
		
		case '==':
		case 'r':
		default:
			$boolOut = ($operand1 == $operand2) ? true : false;
	}
	
	//Если есть дополнительные данные
	if (isset($placeholders)){
		//Разбиваем их
		$placeholders = ddTools::encodedStringToArray($placeholders);
	}else{
		$placeholders = [];
	}
	
	//Backward compatibility
	if (
		isset($trueString) ||
		isset($falseString)
	){
		ddTools::logEvent([
			'message' => '<p>The “trueString” and “falseString” parameters are deprecated. Please use instead “trueChunk” and “falseChunk” with the “@CODE:” prefix.</p>'
		]);
		
		if (isset($trueString)){$trueChunk = '@CODE:'.$trueString;}
		if (isset($falseString)){$falseChunk = '@CODE:'.$falseString;}
	}
	
	//Select output chunk
	$resultChunk = $boolOut ? (isset($trueChunk) ? $trueChunk : '') : (isset($falseChunk) ? $falseChunk : '');
	
	//$modx->getTpl('@CODE:') returns '@CODE:' O_o
	$resultChunk = $modx->getTpl($resultChunk != '@CODE:' ? $resultChunk : '');
	
	$result = $modx->parseText(
		$resultChunk,
		$placeholders
	);
}

return $result;
?>