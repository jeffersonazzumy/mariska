<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 06/09/2019
 * Time: 10:37
 */

namespace Mariska;


abstract class Router
{

    protected $uri = '';

    protected $method;

    protected $routes = [];

    protected $route = ['routes'=>[] ,'path'=>''];

    protected $controller = '';

    protected $path = '';

    protected $search;

    public function __construct($uri = '')
    {
        $this->uri = !empty($uri) ? $uri : $_SERVER["REQUEST_URI"];
        $this->path = trim(ltrim(rtrim(parse_url($this->uri)["path"],"/"),"/"));
    }

    protected function parserRoute($method, $route, $controller)
    {
        $search_replace = strpbrk(str_replace("/"," ", $route),":");

        $search['search'] = ($search_replace) ? $search_replace : "";
        $route = trim(ltrim (  rtrim($route,"/"), "/"  ));
        $path = $this->path;
        $controller = trim ($controller);
        $veb_http = $method;

        $this->routes[] = [
            "path" => $path,
            "veb_http" => $veb_http,
            "route"=> $route,
            "search" => $search,
            "controller" => $controller
        ];

        $this->route();
        return $this;
    }

    public function route()
    {

        foreach ($this->routes as $value) {
            $routes = $value;
            $path = explode("/", $routes['path']);
            $count_path = count($path);
            $route = explode("/", $routes['route']);
            $count_rout = count($route);
            $equality = array_intersect_assoc($route, $path);

            if (isset($equality[0])) {
                if ($count_path == $count_rout) {
                    $new_route = implode("/", array_intersect_assoc($path, $route));
                    $new_search = array_diff_assoc($path, $route);
                    $routes['path'] = $new_route;
                    $routes['route'] = $new_route;
                    if (($new_search == 1)) {
                        $routes['search']['search'] = implode(" ", $new_search);
                    } elseif (($new_search >= 2)) {
                        $routes['search']['search'] = end($new_search);
                        unset($new_search[array_key_last($new_search)]);
                        $routes['search']['path'] = implode(" ", $new_search);
                    }

                    $this->route['routes'] = $routes;
                    $this->route['path'] = $this->path;
                }
            }
        }

      return $this;
    }

    public function execute(){
        return $this->route;
    }
}