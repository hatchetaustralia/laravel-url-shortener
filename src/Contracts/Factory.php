<?php

namespace Hatchet\UrlShortener\Contracts;

interface Factory
{
    /**
     * Get a shortener instance.
     *
     * @param string|null $name
     * @return \Hatchet\UrlShortener\Contracts\Shortener
     */
    public function shortener(string $name = null);
}
