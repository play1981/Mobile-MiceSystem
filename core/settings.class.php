<?php	final class Settings {		// Добавляем настройку		public static function Add($params) {						$db = DB::getInstance();			$data = array(	'`description`' => $params['description'],							'`key`' => $params['key'],							'`value`' => $params['value'],							'`enabled`' => $params['enabled']						);			$db->insert('settings', $data);						$result = DB::getInstance()->select('SELECT max(`id`) AS `new_id` FROM `settings`');			return $result[0]['new_id'];		}					// Редактируем настройку		public static function Edit($params) {					$db = DB::getInstance();			$data = array(	'`description`' => $params['description'],							'`key`' => $params['key'],							'`value`' => $params['value'],							'`enabled`' => $params['enabled']						);			$db->update('settings', $data, 'id LIKE "'.$params['setid'].'"');			return $params['setid'];		}			// Удаляем настройку		public static function Delete($setid) {			$db = DB::getInstance()->query('UPDATE `settings` SET `enabled`=0 WHERE `id` LIKE "'.$setid.'"');			return 'DeleteOK';		}	}?>