<?php
	final class Auth {
		public static function Logon($login, $password, $verification) {
			$query = 'SELECT a.*, b.`name` AS `group_name`
					  FROM `users` a
					  LEFT JOIN `groups` b ON a.`group_id` = b.`id`
					  WHERE UPPER(a.`login`) = UPPER("'.$login.'") AND
							UPPER(a.`password`) = UPPER("'.$password.'") AND
							a.`group_id` IN (1,3,4,5) AND
							a.`enabled` = 1
					  LIMIT 1';
			$result = DB::getInstance()->select($query);

			if (count($result) == 1 && $_SESSION['VERIFICATION'] == $verification) {
				// Обновляем информацию о времени последнего посещения сайта
				$update = DB::getInstance()->update('users', array('date_last' => mktime()), 'id='.$result[0]['id']);

				return array('result_code'=>'LogonOK',
							 'user_id'=>$result[0]['id'],
							 'group_id'=>$result[0]['group_id'],
							 'group_name'=>$result[0]['group_name'],
							 'user_login'=>$result[0]['login']);
			}
			else {
				return array('result_code'=>'LogonError');
			}
		}

		// Проверка разрешения на выполнение скрипта
		public static function CheckPermission($script_name, $group_id) {
			// Новому пользователю присваиваем группу GUEST, чтобы он смог залогиниться
			if (empty($group_id)) {
				$result = DB::getInstance()->select('SELECT `id` FROM `groups` WHERE `name` LIKE "guest"');
				$group_id = $result[0]['id'];
				$_SESSION['Auth']['group_id'] = $group_id;
				$_SESSION['Auth']['group_name'] = 'guest';
			}
			$result = DB::getInstance()->select('
				SELECT `permission` FROM `scriptpermissions`
				WHERE `group_id` = '.$group_id.' AND
					  `script_id` IN (SELECT `id` FROM `scripts` WHERE `action` LIKE "'.$script_name.'")');
			if (count($result) > 0) {
				return $result[0]['permission'];
			}
			else {
				return '0';
			}
		}

		public static function Logout() {
			$_SESSION['Auth'] = '';
			unset($_SESSION['Auth']);
		}
	}
?>