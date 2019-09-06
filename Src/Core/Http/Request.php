<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 04/09/2019
 * Time: 11:22
 */

namespace Mariska\Core\Http;


use Mariska\Core\Http\Interfaces\RequestInterface;

class Request implements RequestInterface
{

    protected $method;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function getMethod()
    {
        return $this->method;
    }
}