<?php


class Router {
    //put your code here
    private $routes;
    
    public function __construct() {
        $RoutPach = ROOT . '/config/routes.php';
        $this -> routes = include ($RoutPach);
    }
    
    private function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])){
            
            return trim($_SERVER['REQUEST_URI'],'/');
        }
    }
    
    public function run(){
        
        $uri = $this ->getURI();
        
        foreach ($this -> routes as $keyRoutes => $valueRoutes){
            
            if(preg_match("~$keyRoutes~", $uri)){
                
                $internalRouter = preg_replace("~$keyRoutes~", $valueRoutes, $uri);
                
                
                $segments = explode('/', $internalRouter);
                
                $controllerName = array_shift($segments). 'Controller';
                
                $controllerName = ucfirst($controllerName);
                
                $actionName = 'action' . ucfirst(array_shift($segments));
                
                $parametrs = $segments;
                
               //Подключаем файл класса контроллера
                
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';
                
                if(file_exists($controllerFile)) {
                    include_once($controllerFile);
                    
                    $controllerObject = new $controllerName;
                    $result = call_user_func_array(array($controllerObject, $actionName),$parametrs);
                    
                    if($result != NULL) {
                        break;
                    }
                }
            }
        }
    }
}
