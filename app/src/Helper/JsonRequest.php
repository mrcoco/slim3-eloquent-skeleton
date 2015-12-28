<?php
namespace App\Helper;

use \Psr\Http\Message\ServerRequestInterface as HTTPRequest;

class JsonRequest {

  private $requestParams = [];

  function __construct(HTTPRequest $request = null)
  {
    if ($request) {
      $this->setRequest($request);
    }
  }

  public function setRequest(HTTPRequest $request)
  {
    $parsedBody = $request->getParsedBody();
    if (is_array($parsedBody)) {
      $this->requestParams = array_merge($this->requestParams, $parsedBody);
    }

    $queryParams = $request->getQueryParams();
    if (is_array($queryParams)) {
      $this->requestParams = array_merge($this->requestParams, $queryParams);
    }

    return $this;
  }

  /**
   * Retrieve a specific request param
   *
   * @param string $name
   * @param mixed $default
   *
   * @return mixed
   */
  public function getRequestParam($name, $default = null)
  {
    if (array_key_exists($name, $this->requestParams)) {
      return $this->requestParams[$name];
    }

    return $default;
  }

  /**
   * Retrieve all request params
   *
   * @return array
   */
  public function getRequestParams() {
    return $this->requestParams;
  }
}