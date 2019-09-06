<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 05/09/2019
 * Time: 18:40
 */

namespace Mariska\Router\Core;
use InvalidArgumentException;
use Mariska\Core\Http\Request;

class Dispatch
{

    private $routes = [];

    private $path = '';

    private $nameSpace = '';

    private $handler;

    private $suffix = ":";

    private $args = [];

    private $request;

    public function __construct()
    {

        $this->request = new Request();
        $this->path = parse_url($_SERVER["REQUEST_URI"])["path"];
        $this->dispatch();
    }


    public function nameSpace($nameSpace)
    {
        $this->nameSpace = $this->validateNameSpace($nameSpace);
        return $this;
    }

    public function route($http_verb, $route, $handler)
    {

        $this->checkHandler($handler);

        $this->handler = $handler;

        $this->routes[$route] = [
            "verb" => $http_verb,
            "route" => $route,
            "nameSpace" => $this->nameSpace,
            "controller" => $this->controller(),
            "action" => $this->action(),
            "args" => $this->args
        ];

       return $this;
    }

    public function dispatch()
    {
        $route = null;
        $erro1 = "classe não existe";

        if (isset($this->routes[$this->path])) {

            $route = $this->routes[$this->path];

            if (is_callable($route['controller'])) {

                call_user_func($route['controller'], ("implementar"));

                return true;

            }

                $controller = "{$route['nameSpace']}" . "\\" . "{$route['controller']}";

                if (class_exists($controller)) {

                    $controller = new $controller;

                    if (method_exists($controller, $route['action'])) {

                        $action = $route['action'];

                        $controller->$action("implementar");

                        return true;
                    }

                }
                echo $erro1;
                return false;
            }

        return false;
    }

    private function validSuffix($suffix)
    {

        if (!preg_match("/^[@,:,\/]$/",$suffix)){
            return ":";
        }
        return $suffix;

    }

    public function setSuffix($suffix)
    {

        $this->suffix = $this->validSuffix($suffix);

    }

    private function checkHandler($handler)
    {
        if (!(is_string($handler) || is_callable($handler))) {

            throw new InvalidArgumentException("the handler must be a string or callable");
        }
    }

    private function validateNameSpace($nameSpace)
    {

        if (!is_string($nameSpace)){
            throw new InvalidArgumentException("the namespace must be a string");
        }

        $nameSpace = str_replace("/","\\", (string)$nameSpace );

        $nameSpace = str_replace("\\"," ", (string)$nameSpace );

        $nameSpaceParts = explode(" ", ucwords($nameSpace));

        return  implode("\\", $nameSpaceParts);

    }

    private function action()
    {
        if (is_string($this->handler) && !is_callable($this->handler)){

            $action = explode($this->suffix,$this->handler)[1];

            return $action;
        }
        return false;
    }

    private function controller()
    {

        if (is_string($this->handler) && !is_callable($this->handler)){

            if (!(strlen($this->suffix) == 1))
            {
                throw new InvalidArgumentException("the suffix is invalid! the default ( / , : , @ )");
            }

            $controller = ucwords(explode($this->suffix,$this->handler)[0]);

            return $controller;

        }

        return $this->handler;
    }

}