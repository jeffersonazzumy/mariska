<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 05/09/2019
 * Time: 13:05
 */

namespace Mariska;


use Mariska\Core\Dispatch;

class Route extends Dispatch
{

    private $nameSpace = '';

    public function addNameSpace($nameSpace)
    {
        $this->nameSpace = $nameSpace;
        return $this;
    }

    public function add($http_verb, $route, $controller)
    {
        $verb = [
            "GET" => true,
            "POST" => true,
            "PUT" => true,
            "DELETE" => true
        ];

        if (isset($verb[$http_verb])){

            $this->route($http_verb, $route, $controller);

        }else{

            echo "eroo";
        }

    }

}