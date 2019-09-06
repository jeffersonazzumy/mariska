<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 05/09/2019
 * Time: 11:53
 */

namespace Mariska;

use Mariska\Router\Route;

class Mariska
{

    /**
     * @var Route
     */
    private $route;

    public function __construct()
    {
        $this->route = new Route();

    }


    public function nameSpaceRoute($nameSpace)
    {
        $this->route->nameSpace($nameSpace);
    }

    public function createRoute($http_verb, $route, $controller)
    {
        $this->route->add($http_verb, $route, $controller);
    }

    public function execute()
    {
        $this->route->dispatch();
    }

}