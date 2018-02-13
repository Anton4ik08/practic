<?php
spl_autoload_register(function ($className){
    $array_paths =array('/models/','/components/');
    
    foreach ($array_paths as $path){
        $path = ROOT . $path . $className . '.php';
        if(is_file($path)){
            include_once $path;
        }
    }
});
//function __autoload($className){
//    
//    $array_paths =array('/models/','/components/');
//    
//    foreach ($array_paths as $path){
//        $path = ROOT . $path . $className . '.php';
//        if(is_file($path)){
//            include_once $path;
//        }
//    }
//}

