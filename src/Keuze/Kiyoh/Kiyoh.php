<?php

declare(strict_types=1);

namespace Keuze\Kiyoh;

use Exception;
use GuzzleHttp\Client;
use Keuze\Kiyoh\Factory\ReviewFactory;
use Keuze\Kiyoh\Model\Company;
use Keuze\Kiyoh\Model\Review;
use Keuze\Kiyoh\Model\ReviewContent;

class Kiyoh
{
    public const COMPANY_REVIEWS_URL = 'https://www.kiyoh.com/v1/review/feed.xml?hash=%s&limit=%s';

    private Client $client;
    private Company|null $fallback;

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

    /*
     * Set the fallback company information.
     * 
     * @param array $data
     */
    public function setFallbackCompany(array $data): void
    {
        $company = new Company(
            (float) ($data['averageRating'] ?? 0.0),
            (int) ($data['numberReviews'] ?? 0),
            (float) ($data['last12MonthAverageRating'] ?? 0.0),
            (int) ($data['last12MonthNumberReviews'] ?? 0),
            (int) ($data['percentageRecommendation'] ?? 0),
            (int) ($data['locationId'] ?? 0),
            locationName: $data['locationName'] ?? ''
        );

        $reviews = [];

        if (!array_key_exists('reviews', $data)) {
            $data['reviews'] = [];
        }
        foreach ($data['reviews'] as $fallBackReview) {
            $review = new Review(
                (string) ($fallBackReview['id'] ?? ''),
                (string) ($fallBackReview['reviewAuthor'] ?? ''),
                (string) ($fallBackReview['city'] ?? ''),
                (float) ($fallBackReview['rating'] ?? 0.0),
                (string) ($fallBackReview['comment'] ?? ''),
                (string) ($fallBackReview['dateSince'] ?? ''),
                (string) ($fallBackReview['updatedSince'] ?? ''),
                (string) ($fallBackReview['referenceCode'] ?? '')
            );

            $review->setContent(
                [
                    new ReviewContent(
                        (string) ($fallBackReview['questionGroup'] ?? 'DEFAULT_OPINION'),
                        (string) ($fallBackReview['questionType'] ?? 'TEXT'),
                        (string) ($fallBackReview['content'] ?? ''),
                        (int) ($fallBackReview['order'] ?? 0),
                        (string) ($fallBackReview['questionTranslation'] ?? '')
                    )
                ],
            );

            $reviews[] = $review;
        }

        $company->setReviews($reviews);

        $this->fallback = $company;
    }

    public function getFallbackCompany(): Company|null
    {
        return $this->fallback ?? null;
    }
}
