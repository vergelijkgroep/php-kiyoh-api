<?php

declare(strict_types=1);

namespace Keuze\Kiyoh;

use Exception;
use GuzzleHttp\Client;
use Keuze\Kiyoh\Factory\ReviewFactory;
use Keuze\Kiyoh\Model\Company;

class Kiyoh
{
    public const COMPANY_REVIEWS_URL = 'https://www.kiyoh.com/v1/review/feed.xml?hash=%s&limit=%s';

    private Client $client;

    /**
     * Kiyoh constructor.
     *
     * @param int    $reviewCount  A number of reviews to retrieve
     */
    public function __construct(private string $connectorCode, private int $reviewCount = 10, private int $requestTimeout = 2)
    {
        $this->client = new Client();
    }

    /**
     * Retrieve the company information from the Kiyoh API.
     *
     * @return Company The company information.
     * @throws Exception If an error occurs during the operation.
     */
    public function getCompany(): ?Company
    {
        return $this->parseData($this->getContent());
    }

    protected function parseData(?string $content = null): Company
    {
        if ($content === null) {
            $content = $this->getContent();
        }

        $content = simplexml_load_string($content);

        return ReviewFactory::createCompany($content);
    }

    public function getContent(): string
    {
        return $this->getClient()->request('GET', $this->getCompanyURL(), ['timeout' => $this->requestTimeout])->getBody()->getContents();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Returns parsed Recent Company Reviews URL.
     */
    public function getCompanyURL(): string
    {
        return sprintf(self::COMPANY_REVIEWS_URL, $this->connectorCode, $this->reviewCount);
    }
}
