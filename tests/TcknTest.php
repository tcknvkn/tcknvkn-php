<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: tests/TcknTest.php
 * Açıklama: TCKN doğrulama fonksiyonları için varyasyonlu birim testlerini içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn\Tests;

use PHPUnit\Framework\TestCase;
use TcknVkn\Tckn;

final class TcknTest extends TestCase
{
    public function testValidateReturnsValidForKnownTckn(): void
    {
        $result = Tckn::validate('10000000146');

        self::assertTrue($result->valid);
        self::assertSame('10000000146', $result->value);
        self::assertSame([], $result->errors);
    }

    public function testValidateNormalizesNonDigitCharacters(): void
    {
        $result = Tckn::validate('100-000 00146');

        self::assertTrue($result->valid);
        self::assertSame('10000000146', $result->value);
    }

    public function testValidateRejectsWrongLength(): void
    {
        $result = Tckn::validate('12345');

        self::assertFalse($result->valid);
        self::assertContains('11 haneli olmalıdır.', $result->errors);
    }

    public function testValidateRejectsLeadingZero(): void
    {
        $result = Tckn::validate('01234567890');

        self::assertFalse($result->valid);
        self::assertContains('İlk hane 0 olamaz.', $result->errors);
    }

    public function testValidateRejectsChecksumFailure(): void
    {
        $result = Tckn::validate('10000000145');

        self::assertFalse($result->valid);
        self::assertNotSame([], $result->errors);
    }

    public function testValidateRejectsAllSamePattern(): void
    {
        $result = Tckn::validate('11111111111');

        self::assertFalse($result->valid);
        self::assertContains('Geçersiz örüntü: tüm haneler aynı.', $result->errors);
    }

    public function testValidateCollectsMultipleErrorsForShortAndLeadingZero(): void
    {
        $result = Tckn::validate('0');

        self::assertFalse($result->valid);
        self::assertContains('11 haneli olmalıdır.', $result->errors);
        self::assertContains('İlk hane 0 olamaz.', $result->errors);
    }

    public function testValidateMultipleReturnsResultList(): void
    {
        $results = Tckn::validateMultiple([
            '10000000146',
            '10000000145',
            '11111111111',
        ]);

        self::assertCount(3, $results);
        self::assertTrue($results[0]->valid);
        self::assertFalse($results[1]->valid);
        self::assertFalse($results[2]->valid);
    }

    public function testValidateMultipleReturnsEmptyListForEmptyInput(): void
    {
        $results = Tckn::validateMultiple([]);

        self::assertSame([], $results);
    }
}
