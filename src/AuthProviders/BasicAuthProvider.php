<?php


namespace Continuity\ApiClient\AuthProviders;


use Continuity\ApiClient\AuthProviderInterface;
use GuzzleHttp\Psr7\Request;

class BasicAuthProvider
    implements AuthProviderInterface
{
    /** @var string */
    private $_username;

    /** @var string */
    private $_password;

    public function __construct(string $username, string $password)
    {
        $this->_username = $username;
        $this->_password = $password;
    }

    public function updateRequest(Request $request): Request
    {
        $hash = base64_encode("{$this->_username}:{$this->_password}");
        $auth = "Basic $hash";
        $request->withHeader('Authorization', $auth);
    }
}