<?php
	final class DB {
	
		private static $instance;
		
		private static function getStorage($config) {
			return(new MySQL($config));
		}
		
		public static function getInstance() {
			if ( !isset(self::$instance) ) {
				self::$instance = self::getStorage(Config::getInstance()->get('MYSQL'));
			}
			return(self::$instance);
		}
	
	}
?>