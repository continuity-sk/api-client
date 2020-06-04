<?php


namespace Continuity\ApiClient;

use GuzzleHttp\Psr7\Request;

interface AuthProviderInterface
{
    public function updateRequest(Request $request): Request;
}