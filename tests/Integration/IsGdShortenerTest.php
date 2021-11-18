<?php

namespace Hatchet\UrlShortener\Tests\Integration;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Hatchet\UrlShortener\Http\IsGdShortener;
use Hatchet\UrlShortener\Tests\Concerns\HasUrlAssertions;
use PHPUnit\Framework\TestCase;

class IsGdShortenerTest extends TestCase
{
    use HasUrlAssertions;

    /**
     * @var \Hatchet\UrlShortener\Http\IsGdShortener
     */
    protected $shortener;

    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->shortener = new IsGdShortener(new Client, 'https://is.gd', false);
    }

    /**
     * Test Is.gd synchronous shortening.
     *
     * @return void
     */
    public function testShorten()
    {
        $shortUrl = $this->shortener->shorten('https://google.com');

        $this->assertValidUrl($shortUrl);
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }

    /**
     * Test Is.gd asynchronous shortening.
     *
     * @return void
     */
    public function testShortenAsync()
    {
        $promise = $this->shortener->shortenAsync('https://google.com');

        $this->assertInstanceOf(PromiseInterface::class, $promise);
        $this->assertValidUrl($shortUrl = $promise->wait());
        $this->assertRedirectsTo('https://google.com', $shortUrl, 1);
    }
}
