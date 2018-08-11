<?php
	// Класс шаблонизатора

/*
	// Если установлен Blitz
	class Tpl extends Blitz {
	}
*/


	// Если нету Blitz-а
	class Tpl{
		var $tpl_file;

		// Инициализация шаблонизатора: загрузка файла в массив, парсинг
		function Tpl($tpl_file, $include_params = array()) {
			// Инициализируем массив со структурой сайта
			$this -> tpl_array_html = array();
			
			// Инициализируем массив с исходниками подшаблонов
			$this -> tpl_array_source = array(); 
			$this -> tmp_array_source = array(); 
			
			// Заполняем массив исходников
			$this -> tpl_array_source = $this -> getNodes($this -> loadTplFile($tpl_file, $include_params));

			// Заполняем source для шаблона /root
			$this -> block('');
		}


		// Загружаем шаблон в память, объединяем его со вложенными шаблонами и т.п.
		function loadTplFile($tpl_file, $include_params = array()) {
			if (!file_exists($tpl_file)) {
				//echo '<p align="center">Не найден шаблон <b>'.$tpl_file.'</b></p>';
				//exit;
				return;
			};

			$fp = fopen($tpl_file, 'r');
			while (!feof($fp)) {
				// Загружаем одну строку из файла-шаблона
				$fline =trim(fgets($fp, 8192));

	
				// Если были переданы ГЛОБАЛЬНЫЕ параметры - вставляем их в наш код
				if ($include_params) {
					foreach ($include_params as $key => $value) {
						$reg_var = '###'.$key.'###';
						$fline = str_ireplace($reg_var, $value, $fline);
					}					
				}
					

				preg_match_all("/(?<={{include\(\")[\/\?\&\#a-z.0-9_=-]+(?=\"\)}})/i",  str_replace(' ', '', $fline), $matches);

				if (count($matches[0]) > 0) {
					foreach($matches[0] AS $includes_link) {

						// Если инклудится php-файл, то выполняем встроенную в него функцию.
						// Имя встроенной функции ОБЯЗАНО совпадать с именем файла!!!
						if (substr_count($includes_link, '.php') > 0) {
							$includes_tmp = explode('?', $includes_link);
							$includes_params = count($includes_tmp) > 1 ? explode('&', $includes_tmp[1]) : '';

							require_once($includes_tmp[0]);
							$function = str_replace('-', '_', substr(basename($includes_tmp[0]), 0, strlen(basename($includes_tmp[0]))-4));
							array_push($this -> tpl_array_source, $function($includes_params));
						}
						else {
							$this -> loadTplFile($includes_link);
						}
					}
				}
				else array_push($this -> tpl_array_source, $fline);
			}
			fclose($fp);

			return $this -> tpl_array_source;
		}



		// Генерация структуры массива для шаблонов сайта и заполнение html-блоков		
		function block($name, $params='') {
	
				// Получаем исходный код для текущего шаблона $name
				$tpl_source = $this -> tpl_array_source['/root'.$name]['source'];

				// Если были переданы параметры - вставляем их в наш код
				if ($params) {
					foreach ($params as $key => $value) {
						if (is_array($value)) {
							$this -> block($name.'/'.$key, $value); // Это я уже не помню для чего
						}
						else {
							// Меняем в исходном коде все переменные на их значения
							//$tpl_source = eregi_replace("{{[ ]*[$".$key."]+[ ]*}}", "$value", $tpl_source);

//							$reg_var = '/\{\{[ ]*[\$pid]+[ ]*\}\}/i';
//							$tpl_source = preg_replace($reg_var, $value, $tpl_source);
						
							// Временное решение проблемы
							$reg_var = '{{ $'.$key.' }}';
							$tpl_source = str_ireplace($reg_var, $value, $tpl_source);
						}
					}
				}


				// Определяем имя родительского шаблона
				$tpl_name_parent = substr('/root'.$name, 0, strrpos('/root'.$name, '/'));
	
				// Определяем ID последнего родительского шаблона (находим последний элемент в родительском шаблоне)
				$last_parent = count($this -> tpl_array_html[$tpl_name_parent])-1;
	
			
				// Если подшаблон с указаным именем уже существует, то создаём ещё один элемент для данного подшаблона
				if (array_key_exists('/root'.$name, $this -> tpl_array_html) ) {
					array_push($this -> tpl_array_html['/root'.$name], array('parent_id' => $last_parent, 'html' => $tpl_source));
				}
				// Иначе создаём новую ветку для нового подшаблона
				else {
					$tmp_array = array(
						'/root'.$name => array(
							array('parent_id' => $last_parent, 'html' => $tpl_source)
						)
					);
					$this -> tpl_array_html = array_merge($this -> tpl_array_html, $tmp_array);
				}

		}


		// Собираем все блоки в один HTML-код
		function parse() {
			// Вызываем рекурсивную функцию для подстановки дочерних шаблонов в родительские
			$this -> tpl_content = $this -> parse_recursive($this -> tpl_array_html['/root'][0][html], 0);

			// Обрабатываем условия (if) из конечного шаблона
			preg_match_all("/(?<={{ if\()[^}]*(?=\) }})/i",  $this -> tpl_content, $matches);
//print_r($matches);
			if (count($matches[0]) > 0) {
				foreach($matches[0] AS $cases) {
//preg_match_all('#(\'|")(.*)(\'|")#siU', $cases, $res);
//print_r($res);
//exit;

					$values = explode(',', $cases); // Косячище!!! Из-за которого нельзя использовать запятые в тексте!!!
					eval("if (".$values[0].") { \$result=trim($values[1]); } else { \$result=trim($values[2]); }");
					$this -> tpl_content = preg_replace("/{{ if[^}]*}}/i", $result, $this -> tpl_content, 1);
				}
			}

			return preg_replace("/{{[ ]*[$\/a-z.0-9_-]+[ ]*}}/i", "", $this -> tpl_content); // убираем оставшиеся незаполненными элементы {{ $var_name }}
		}





		// Рекурсивная функция для подстановки дочерних шаблонов в родительские
		function parse_recursive ($data, $parent_id) {

			// Находим имена всех подшаблонов в текущем шаблоне
			while (preg_match_all("/(?<=TPL\s)\/root[\/a-zA-Z0-9_-]+(?=\s}})/i", $data, $matches)) {

				// Просматриваем все найденные имена подшаблонов
				foreach($matches[0] AS $tpl_name) {

					// Проверяем, существует ли вообще такой шаблон
					if (array_key_exists($tpl_name, $this -> tpl_array_html) ) {
						
						$tpl_tmp = '';
						
						// Пробегаемся по всем шаблонам, если их несколько, и ищем тот, у которого parent_id равно id текущего шаблона
						foreach ($this -> tpl_array_html[$tpl_name] AS $key => $tpl_elem) {
							
							// Если parent_id подшаблона равно id шаблона, из которого он вызывается
							if ($tpl_elem['parent_id'] == $parent_id) {
								$tpl_tmp .= $this -> parse_recursive($tpl_elem['html'],  $key);
							}
						}
						$data = str_replace('{{ TPL '.$tpl_name.' }}', $tpl_tmp, $data);
						
					}
					// Если данного шаблона почему-то нет, то замещаем место его вызова пустым значением
					else {
						$data = str_replace('{{ TPL '.$tpl_name.' }}', '', $data);
					}


				}
			}
			return $data;
		}




		// Разбиение файла шаблоны на ассоциативный массив с исходниками для каждого подшаблона
		function getNodes($tpl_file) {
			$tpl_name = '/root';
			$tpl_array_source = array();
			$tpl_names_array = array();


			foreach($tpl_file AS $line) {
				$line = trim($line);

				// Если встретили {{ BEGIN имя_подшаблона }}, создаём новый элемент массива
				if (preg_match("/{{[ ]*BEGIN[ ]*[A-Z0-9_-]+[ ]*}}/i", $line)) {
					// Определяем имя нового подшаблона
					$tpl_name_new = $tpl_name.'/'.trim(substr($line, stripos($line, 'BEGIN')+5, strpos($line, '}}')-stripos($line, 'BEGIN')-5));
					array_push($tpl_names_array, $tpl_name);

					// Делаем в вышестоящем шаблоне переменную с названием нового подшаблона
					$tpl_array_source[$tpl_name]['source'] .= "{{ TPL $tpl_name_new }}";

					// Делаем текущим новый подшаблон
					$tpl_name = $tpl_name_new;
				} 
				else if (preg_match("/{{[ ]*END[ ]*}}/i", $line)) {
					$tpl_name = array_pop($tpl_names_array);
				}
				else {
					// Заносим строчку в массив в элемент с соответствующим именем
					$tpl_array_source[$tpl_name]['source'] .= $line;
				}
				unset($line);
			}
		
			return $tpl_array_source;
		}

	}

?>