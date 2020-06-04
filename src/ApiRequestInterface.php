<?php

namespace Continuity\ApiClient;

interface ApiRequestInterface
{
    public function isAuthenticated(): bool;

    public function getResource(): string;

    public function getMethod(): string;

    public function getResponseType(): string;
}