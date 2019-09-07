<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 05/09/2019
 * Time: 13:05
 */

namespace Mariska;


class Route extends Router
{

    public function __construct($uri = '')
    {
        parent::__construct($uri);
    }

    public function get($route, $controller)
    {
        $this->parserRoute("GET", $route, $controller);
    }

    public function post($route, $controller)
    {
        $this->parserRoute("POST", $route, $controller);
    }

    public function put($route, $controller)
    {
        $this->parserRoute("PUT", $route, $controller);
    }

    public function delete($route, $controller)
    {
        $this->parserRoute("DELETE", $route, $controller);
    }

}