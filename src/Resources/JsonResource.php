<?php

namespace Pokemon\Resources;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Pokemon\Pokemon;
use Pokemon\Resources\Interfaces\ResourceInterface;
use Psr\Http\Message\ResponseInterface;
use stdClass;

/**
 * Class JsonResource
 *
 * @package Pokemon\Resources
 */
class JsonResource implements ResourceInterface
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var string
     */
    protected $uri;

    protected $response;

    /**
     * Request constructor.
     *
     * @param string $uri
     * @param array  $options
     */
    public function __construct($uri, array $options = [])
    {
        $defaults = [
            'base_uri' => Pokemon::API_URL,
            'verify'   => false,
        ];
        $this->uri = $uri;
        $this->client = new Client(array_merge($defaults, $options));
    }

    /**
     * @return Request
     */
    protected function prepare()
    {
        return new Request($this->method, $this->uri);
    }

    /**
     * @param ResponseInterface $response
     *
     * @return mixed
     */
    protected function getResponseData(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param stdClass $data
     *
     * @return array
     */
    protected function transformAll(stdClass $data)
    {
        return $this->getFirstProperty($data);
    }

    /**
     * @param stdClass $data
     *
     * @return string|null
     */
    protected function getFirstPropertyName(stdClass $data)
    {
        $attributes = get_object_vars($data);

        return (count($attributes) > 0) ? array_keys($attributes)[0] : null;
    }

    /**
     * @param stdClass $data
     *
     * @return mixed
     */
    protected function getFirstProperty(stdClass $data)
    {
        return $data->{$this->getFirstPropertyName($data)};
    }

    /**
     * @return array
     */
    public function all()
    {
    	$this->send();
        $data = $this->getResponseData($this->response);
        return $this->transformAll($data);
    }

	/**
	 * Sends the request and sets response property.
	 *
	 * @return $this
	 */
	public function send()
    {
    	$this->response = $this->client->send($this->prepare());
    	return $this;
    }

	/**
	 * Gets the headers from the response.
	 * @return mixed
	 */
	protected function headers()
    {
    	$this->sendIfNotAlready();
	    return $this->response->getHeaders();
    }

	/**
	 * Gets the total number of results from response header.
	 * @return mixed
	 */
	public function total()
    {
	    $this->sendIfNotAlready();
    	return $this->response->getHeader('Total-Count')[0];
    }

	/**
	 * Gets the number of results per page from response header.
	 * @return mixed
	 */
	public function perPage()
	{
		$this->sendIfNotAlready();
		return $this->response->getHeader('Count')[0];
	}

	/**
	 * Gets the number of pages for all results.
	 *
	 * @return float
	 */
	public function totalPages()
	{
		return $this->total() == 0 ? 1 : ceil($this->total() / $this->perPage());
	}

	/**
	 *  Sends the requests if not already sent.
	 */
	protected function sendIfNotAlready()
	{
		if(!$this->response){
			$this->send();
		}
	}
}