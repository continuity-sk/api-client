<?php

namespace Continuity\ApiClient;

abstract class AbstractApiRequest
    implements ApiRequestInterface
{
    /** @var bool */
    protected $isAuthenticated = false;

    /** @var string */
    protected $resource;

    /** @var string */
    protected $method = HttpMethod::GET;

    /** @var string */
    protected $responseType = ResponseType::JSON;

    //region --- ApiRequestInterface implementation ---

    /**
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->isAuthenticated;
    }

    /**
     * @return string
     */
    public function getResource(): string
    {
        return $this->resource;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getResponseType(): string
    {
        return $this->responseType;
    }

    //endregion
}