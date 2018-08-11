<?php

    class Registry {
        
        private static $_instance;
        private static $_storage;
        
        public function __clone() {}
        
        public function isExists($name) {
            return(isset(self::$_storage[$name]));
        }
        
        public function get($name) {
            if (isset(self::$_storage[$name])) return(self::$_storage[$name]); else return(false);
        }
        
        public function set($name, $object) {
            self::$_storage[$name] = $object;
            return($object);
        }
        
        public static function getInstance() {
            if (!isset(self::$_instance)) self::$_instance = new self();
            return(self::$_instance);
        }        
        
    }

    final class Config extends Registry {
        
        private static $instance;
        private $config;
        
        private function __construct($config) {
            if (!file_exists($config)) die('Config file not found.');
            if (!$this->config = parse_ini_file($config, true)) die('Error while processing config file.');
        }
        
        public function get($name = null) {
            if (empty($name)) return($this->config);
            if (isset($this->config[$name])) return($this->config[$name]); else return(false);
        }
        
        public static function getInstance() {
            if (!isset(self::$instance)) {
                self::$instance = new self(BASE.'/config.ini');
                self::$instance->set('config', self::$instance);
            }
            return(self::$instance);
        }
        
    }

?>