<?php

namespace Continuity\ApiClient\AuthProviders;

use Continuity\ApiClient\AuthProviderInterface;
use GuzzleHttp\Psr7\Request;

class NoneAuthProvider
    implements AuthProviderInterface
{
    /**
     * @param Request $request
     *
     * @return Request
     */
    public function updateRequest(Request $request): Request
    {
        return $request;
    }
}