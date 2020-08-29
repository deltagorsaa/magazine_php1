<?php
namespace ext;

function isCurrentUrl(string $url): bool
{
    static $currentUrl;
    $currentUrl = $currentUrl ?? strtolower(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

    return $currentUrl === $url;
}
