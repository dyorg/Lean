<?php
namespace Lean\Http;

use Lean\Singleton;

class Request extends Singleton 
{
	public function __construct($http_method = null) {
		if (!$http_method) $http_method = $_REQUEST;
		foreach ($http_method as $key => $value) {
			$this->{$key} = $value;
		}
	}

	/**
	 * @return self
	 */
	public static function singleton() {
		return parent::singleton();
	}

	public function decode($to = 'ISO-8859-1', $from = 'UTF-8') {
		foreach ($this as $key => $value) {
			$this->$key = mb_convert_encoding($value, $to, $from);
		}
		
		return $this;
	}

    /**
     * @return Request
     */
    public function delete() {
        return Post::singleton();
    }

    /**
     * @return Request
     */
    public function files() {
        return Files::singleton();
    }

    /**
     * @return Request
     */
	public function get() {
		return Get::singleton();
	}

    /**
     * @return Request
     */
    public function head() {
        return Post::singleton();
    }

    /**
     * @return Request
     */
    public function post() {
        return Post::singleton();
    }

    /**
     * @return Request
     */
	public function put() {
		return Post::singleton();
	}

    /**
     * @return Method
     */
	public function getMethod() {
		return Method::singleton();
	}

	/**
	 * @return Url
	 */
	public function getUrl() {
		return Url::singleton();
	}
}

/**
 * Class Post
 * @package Lean\Http
 */
class Post extends Request
{
	public function __construct() {
		parent::__construct($_POST);
	}
}

/**
 * Class Files
 * @package Lean\Http
 */
class Files extends Request
{
	public function __construct() {
		parent::__construct($_FILES);
	}
}

/**
 * Class Get
 * @package Lean\Http
 */
class Get extends Request
{
	public function __construct() {
		parent::__construct($_GET);
	}
}

/**
 * Class Url
 * @package Lean\Http
 */
class Url extends Singleton {

	private $uri_parsed;

	/**
	 * @return self
	 */
	public static function singleton() {
		return parent::singleton();
	}

	public function __construct() {
		$this->uri_parsed = parse_url($this->getUri());
	}

	public function getHash() {
		return isset($this->uri_parsed['fragment']) ? $this->uri_parsed['fragment'] : null;
	}

	public function getHost() {
		return $_SERVER['SERVER_NAME'];
	}

	public function getHostWithPort() {
		return $this->getHost() . ':' . $this->getPort();
	}

	public function getPath() {
		return isset($this->uri_parsed['path']) ? $this->uri_parsed['path'] : null;
	}

	public function getPort() {
		return $_SERVER['SERVER_PORT'];
	}

	public function getProtocol() {
		return isset($this->uri_parsed['scheme']) ? $this->uri_parsed['scheme'] : null;
	}

	public function getQuery() {
		return isset($this->uri_parsed['query']) ? $this->uri_parsed['query'] : null;
	}

	public function getUri() {
        $url = strtok($_SERVER['REQUEST_URI'], '?');

        if (empty($url)) {
            return $_SERVER['REQUEST_URI'];
        } else {
            return $url .'?'. urlencode($_SERVER['QUERY_STRING']);
        }
	}

	public function getUrl() {
		return $this->getHost() . $this->getUri();
	}

	public function __toString() {
		return $this->getUrl();
	}
}


/**
 * Class Method
 * @package Lean\Http
 */
class Method extends Singleton {

	const METHOD_DELETE = 'DELETE';
	const METHOD_GET = 'GET';
	const METHOD_HEAD = 'HEAD';
	const METHOD_OPTIONS = 'OPTIONS';
	const METHOD_PATCH = 'PATCH';
	const METHOD_POST = 'POST';
	const METHOD_PUT = 'PUT';

	/**
	 * @return self
	 */
	public static function singleton() {
		return parent::singleton();
	}

	public function getMethod() {
		return $_SERVER['REQUEST_METHOD'];
	}

	public function isDelete() {
		return $this->getMethod() == self::METHOD_DELETE;
	}

	public function isGet() {
		return $this->getMethod() == self::METHOD_GET;
	}

	public function isHead() {
		return $this->getMethod() == self::METHOD_HEAD;
	}

	public function isOptions() {
		return $this->getMethod() == self::METHOD_OPTIONS;
	}

	public function isPatch() {
		return $this->getMethod() == self::METHOD_PATCH;
	}

	public function isPost() {
		return $this->getMethod() == self::METHOD_POST;
	}

	public function isPut() {
		return $this->getMethod() == self::METHOD_PUT;
	}

	public function __toString() {
		return $this->getMethod();
	}
}