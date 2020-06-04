<?php


namespace Continuity\ApiClient\Impl;


use Continuity\ApiClient\ApiClientInterface;
use Continuity\ApiClient\ApiRequestInterface;
use Continuity\ApiClient\AuthProviderInterface;
use Continuity\ApiClient\AuthProviders\NoneAuthProvider;
use Continuity\ApiClient\ResponseType;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class GuzzleApiClient
    implements ApiClientInterface
{
    /**
     * GuzzleApiClient constructor.
     *
     * @param string                     $endpointUrl
     * @param array                      $options
     * @param AuthProviderInterface|null $authProvider
     */
    public function __construct(string $endpointUrl, array $options = [], AuthProviderInterface $authProvider = null)
    {
        $this->_endpointUrl = $endpointUrl;
        $this->_authProvider = $authProvider ?? new NoneAuthProvider();
        $this->_client = self::createClient($endpointUrl, $options);
    }

    /**
     * @param ApiRequestInterface $request
     *
     * @param array               $options
     *
     * @return mixed
     */
    public function send(ApiRequestInterface $request, array $options = [])
    {
        $guzzleRequest = new Request($request->getMethod(), $request->getResource());
        $guzzleRequest = $this->_authProvider->updateRequest($guzzleRequest);

        $guzzleResponse = $this->_client->send($guzzleRequest, array_merge([
            'timeout' => $this->getTimeout(),
        ], $options));

        return self::convertResponse($request, $guzzleResponse);
    }

    /**
     * @return string
     */
    public function getEndpointUrl(): string
    {
        return $this->_endpointUrl;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->_timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout(int $timeout): void
    {
        $this->_timeout = $timeout;
    }

    //region --- Private members ---

    /**
     * @param string $endpointUrl
     * @param array  $options
     *
     * @return Client
     */
    private static function createClient(string $endpointUrl, array $options): Client
    {
        return new Client(array_merge($options, [
            'base_uri' => $endpointUrl,
        ]));
    }

    private static function convertResponse(ApiRequestInterface $request, ResponseInterface $guzzleResponse)
    {
        switch ($request->getResponseType())
        {
            case ResponseType::JSON:
                return json_decode($guzzleResponse->getBody(), true);
            case ResponseType::NATIVE:
                return $guzzleResponse;
        }

        throw new InvalidArgumentException('Unknown response type: '. $request->getResponseType());
    }

    /** @var AuthProviderInterface */
    private $_authProvider;

    /** @var string */
    private $_endpointUrl;

    /** @var Client */
    private $_client;

    /** @var int */
    private $_timeout = 2;
    //endregion

}