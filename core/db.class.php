<<<<<<< HEAD
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
=======
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
>>>>>>> 7c1adfc55f19ed1a45b631b7d312e7e4e12a606f
?>