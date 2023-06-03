<?php
namespace ddIf;

class Snippet extends \DDTools\Snippet {
	protected
		$version = '2.3.0',
		
		$params = [
			//Defaults
			//Required
			'operand1' => null,
			//Если передали, с чем сравнивать, хорошо, если нет — будем с пустой строкой
			'operand2' => '',
			'operator' => '==',
			'trueChunk' => '',
			'falseChunk' => '',
			'placeholders' => [],
			//Unset
			'debugTitle' => null
		],
		
		$paramsTypes = [
			'placeholders' => 'objectArray'
		]
	;
	
	/**
	 * prepareParams
	 * @version 1.2 (2021-04-30)
	 * 
	 * @param $params {stdClass|arrayAssociative|stringJsonObject|stringQueryFormatted}
	 * 
	 * @return {void}
	 */
	protected function prepareParams($params = []){
		//Call base method
		parent::prepareParams($params);
		
		//Если это сырой плейсхолдер, то скорее всего он пустой, и его не обработал парсер, приравняем тогда параметр к пустоте
		if (
			is_string($this->params->operand1) &&
			mb_substr(
				$this->params->operand1,
				0,
				2
			) == '[+' &&
			mb_substr(
				$this->params->operand1,
				-2
			) == '+]'
		){
			$this->params->operand1 = '';
		}
		
		$this->params->operator = mb_strtolower($this->params->operator);
		
		//Backward compatibility
		$operatorBackwardCompliance = [
			'r' => '==',
			'!r' => '!=',
			'b' => '>',
			'm' => '<',
			'br' => '>=',
			'mr' => '<='
		];
		
		if (
			array_key_exists(
				$this->params->operator,
				$operatorBackwardCompliance
			)
		){
			$this->params->operator = $operatorBackwardCompliance[$this->params->operator];
		}
	}
	
	/**
	 * run
	 * @version 1.2.2 (2023-06-03)
	 * 
	 * @return {string}
	 */
	public function run(){
		//The snippet must return an empty string even if result is absent
		$result = '';
		
		//Если передано, что сравнивать
		if (!is_null($this->params->operand1)){
			//Булевое значение истинности сравнения
			$boolOut = '';
			
			//Выбираем сравнение в зависимости от оператора
			switch ($this->params->operator){
				case '!=':
					$boolOut = $this->params->operand1 != $this->params->operand2;
				break;
				
				case '>':
					$boolOut = $this->params->operand1 > $this->params->operand2;
				break;
				
				case '<':
					$boolOut = $this->params->operand1 < $this->params->operand2;
				break;
				
				case '>=':
					$boolOut = $this->params->operand1 >= $this->params->operand2;
				break;
				
				case '<=':
					$boolOut = $this->params->operand1 <= $this->params->operand2;
				break;
				
				case 'bool':
					$boolOut = boolval($this->params->operand1);
				break;
				
				case 'isincludes':
					$boolOut =
						function_exists('str_contains') ?
						//PHP >= 8
						str_contains(
							$this->params->operand1,
							$this->params->operand2
						) :
						//PHP < 8
						(
							$this->params->operand2 === '' ||
							mb_strpos(
								$this->params->operand1,
								$this->params->operand2
							) !== false
						)
					;
				break;
				
				case 'inarray':
					$operand2Array = explode(
						',',
						$this->params->operand2
					);
					
					$boolOut = in_array(
						$this->params->operand1,
						$operand2Array
					);
				break;
				
				case 'isnumeric':
					$boolOut = is_numeric($this->params->operand1);
				break;
				
				case 'iswhitespace':
					$boolOut =
						$this->params->operand1 == '' ||
						ctype_space($this->params->operand1)
					;
				break;
				
				case '==':
				default:
					$boolOut = $this->params->operand1 == $this->params->operand2;
			}
			
			//Select output chunk
			$resultChunk =
				$boolOut ?
				$this->params->trueChunk :
				$this->params->falseChunk
			;
			
			$resultChunk = \ddTools::getTpl($resultChunk);
			
			$result = \ddTools::parseText([
				'text' => $resultChunk,
				'data' => \DDTools\ObjectTools::extend([
					'objects' => [
						[
							'snippetParams.operand1' => $this->params->operand1,
							'snippetParams.operand2' => $this->params->operand2,
							'snippetParams.operator' => $this->params->operator
						],
						$this->params->placeholders
					]
				])
			]);
		}
		
		//Если для отладки нужно вывести то что пришло в сниппет выводим
		if(!is_null($this->params->debugTitle)){
			\ddTools::logEvent([
				'message' =>
					'<p>Snippet parameters:</p><pre><code>' .
					var_export(
						$this->params,
						true
					) .
					'</code></pre>' .
					'<p>Snippet result:</p><pre><code>' .
					var_export(
						$result,
						true
					) .
					'</code></pre>'
				,
				'source' =>
					'ddIf: ' .
					$this->params->debugTitle
			]);
		}
		
		return $result;
	}
}