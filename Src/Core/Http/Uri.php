<?php
/**
 * Created by PhpStorm.
 * User: Jefferson
 * Date: 04/09/2019
 * Time: 00:16
 */


namespace Mariska\Core\Http;
use InvalidArgumentException;

/**
 * Class Uri
 *
 * @package Mariscka\Router\Http
 */
class Uri
{

    /**
     * Uri scheme (without "://" suffix)
     *
     * @var string
     */
    protected $scheme = '';

    /**
     * Uri host
     *
     * @var string
     */
    protected $host ='';

    /**
     * Uri port
     *
     * @var int||null
     */
    protected $port;

    /**
     * Uri user
     *
     * @var string
     */
    protected $user = '';

    /**
     * Uri pass
     *
     * @var string
     */
    protected $pass = '';

    /**
     * Uri path
     *
     * @var string
     */
    protected $path = '';

    /**
     * Uri query
     *
     * @var string
     */
    protected $query = '';

    public function __construct($scheme, $host, $port = null, $path = '/', $query = '',  $user = '', $password = '')
    {
        $this->scheme = $this->checkScheme($scheme);
        $this->host = $host;
        $this->port = $port;
        $this->path = empty($path) ? '/': $path;
        $this->query = $query;
        $this->user = $user;
        $this->pass = $password;

    }

    /**
     * Create new Uri from string.
     *
     * @param  string $uri Complete Uri string
     *     (i.e., https://user:pass@host:443/path?query).
     *
     * @return self
     */
    public static function creatUriString($uri)
    {
        if(!is_string($uri) && !method_exists($uri,"___toString")) {
            throw new InvalidArgumentException("invalid argument to uri must be string only");
        }

        $parser = parse_url($uri);
        $scheme = isset($parser['scheme']) ? $parser['scheme'] : '';
        $host = isset($parser['host']) ? $parser['host'] : '';
        $port = isset($parser['port']) ? $parser['port'] : '';
        $user = isset($parser['user']) ? $parser['user'] : '';
        $pass = isset($parser['pass']) ? $parser['pass'] : '';
        $path = isset($parser['path']) ? $parser['path'] : '';
        $query = isset($parser['query']) ? $parser['query'] : '';

        return new static($scheme, $host, $port, $path, $query, $user, $pass);
    }

    /**
     * @param $scheme
     * @return mixed
     *
     * @throws InvalidArgumentException If the Uri scheme is not a string.
     * @throws InvalidArgumentException If Uri scheme is not "", "https", or "http".
     */
    protected function checkScheme($scheme)
    {
        $schemeValid = [
            '' => true,
            'http' => true,
            'https' => true
        ];

        if (!is_string($scheme) && !method_exists($scheme, "__toString")){
            throw new InvalidArgumentException("");

        }
        $scheme = str_replace('://','',strtolower((string)$scheme));
        if (!isset($schemeValid[$scheme])){
            throw new InvalidArgumentException('Schema must be of type string and must be (\'\', http, or https).');
        }

        return $scheme;
    }

    /**
     * @param $port
     * @return mixed
     *
     * @throws InvalidArgumentException
     * Aprenda a pronunciar
     * if the port Uri is not integer or if it is not null, then it is not between 1 and 65535.
     */
    protected function checkPort($port)
    {
        if ((is_null($port)) || (is_integer($port)) && ($port >= 1) && ($port <= 65535)){
            return $port;
        }

        throw new InvalidArgumentException("port must be between 1 and 65535 and must be integer");
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUser(): string
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }


}