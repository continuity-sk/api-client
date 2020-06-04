<?php


namespace Continuity\ApiClient;


interface ApiClientInterface
{
    public function send(ApiRequestInterface $request);
}