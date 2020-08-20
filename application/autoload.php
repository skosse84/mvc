<?php
class ClassLoader {

    public static $classMap;
    public static $addMap = array();
    public static $dir = [
        'controllers',
        'core',
        'models',
        'views',
    ];


    public static function addClassMap($class = array()){
        self::$addMap = array_merge(self::$addMap, $class);
    }

    public static function test(){
        self::$classMap = array_merge(require('classes.php'), self::$addMap);
    }

    public static function autoload($className){


        self::$classMap = array_merge(require('classes.php'), self::$addMap);


        if (isset(self::$classMap[$className])) {
            $filename = self::$classMap[$className];
            include_once ROOT_DIR . $filename;

        } else {
            self::library($className);
        }


        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new Exception('find class in not possible '.$className);
        }
    }

    public static function library($className){
        foreach (self::$dir as $d){
            $filename = 'application/' . $d . '/'. mb_strtolower($className) . ".php";
            if (is_readable($filename)) {
                require_once $filename;
            }
        }
    }

}