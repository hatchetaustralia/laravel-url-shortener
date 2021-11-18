<?php

namespace Hatchet\UrlShortener\Http;

use Hatchet\UrlShortener\Contracts\AsyncShortener;

abstract class RemoteShortener implements AsyncShortener
{
    /**
     * {@inheritDoc}
     */
    public function shorten($url, array $options = [])
    {
        return $this->shortenAsync($url, $options)->wait();
    }
}
