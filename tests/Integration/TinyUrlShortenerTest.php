<?php

namespace Hatchet\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Hatchet\UrlShortener\Http\TinyUrlShortener;
use Hatchet\UrlShortener\Tests\Concerns\HasUrlAssertions;
use PHPUnit\Framework\TestCase;

class TinyUrlShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \Hatchet\UrlShortener\Http\TinyUrlShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new TinyUrlShortener(new Client);
    }

    /**
     * Test TinyURL synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);

        // Automatic redirect does not occur for TinyURL?
        $this->assertRedirectsTo('https://preview.tinyurl.com/mbq3m', $shortUrl, 1);
    }

    /**
     * Test TinyURL asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertValidUrl($shortUrl = $promise->wait());

        // Automatic redirect does not occur for TinyURL?
        $this->assertRedirectsTo('https://preview.tinyurl.com/mbq3m', $shortUrl, 1);
    }
}
