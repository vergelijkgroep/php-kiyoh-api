<?php

declare(strict_types=1);

namespace Keuze\Kiyoh\Tests\Unit;

use Keuze\Kiyoh\Kiyoh;
use PHPUnit\Framework\TestCase;

final class KiyohTest extends TestCase
{
    private const KIYOH_KEY_ENV_KEY = 'KIYOH_KEY';
    private const REVIEW_COUNT = 5;

    public function testKiyoh()
    {
        $kiyohKey = getenv(self::KIYOH_KEY_ENV_KEY);
        $this->assertNotFalse($kiyohKey);

        $kiyoh = new Kiyoh($kiyohKey, self::REVIEW_COUNT);

        $company = $kiyoh->getCompany();
        $this->assertNotNull($company);

        $averageRating = $company->getAverageRating();
        $this->assertGreaterThan(0, $averageRating);

        $reviews = $kiyoh->getCompany()->getReviews();
        $this->assertNotNull($reviews);
        $this->assertCount(self::REVIEW_COUNT, $reviews);
    }
}
