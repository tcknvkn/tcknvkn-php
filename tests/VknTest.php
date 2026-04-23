<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: tests/VknTest.php
 * Açıklama: VKN doğrulama fonksiyonları için varyasyonlu birim testlerini içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn\Tests;

use PHPUnit\Framework\TestCase;
use TcknVkn\Vkn;

final class VknTest extends TestCase
{
    public function testValidateReturnsValidForKnownVkn(): void
    {
        $result = Vkn::validate('1000036109');

        self::assertTrue($result->valid);
        self::assertSame('1000036109', $result->value);
        self::assertSame([], $result->errors);
    }

    public function testValidateNormalizesNonDigitCharacters(): void
    {
        $result = Vkn::validate('100-003-6109');

        self::assertTrue($result->valid);
        self::assertSame('1000036109', $result->value);
    }

    public function testValidateRejectsWrongLength(): void
    {
        $result = Vkn::validate('1234');

        self::assertFalse($result->valid);
        self::assertContains('10 haneli olmalıdır.', $result->errors);
    }

    public function testValidateRejectsChecksumFailure(): void
    {
        $result = Vkn::validate('1000036108');

        self::assertFalse($result->valid);
        self::assertContains('Son hane kontrol hanesi hatalı.', $result->errors);
    }

    public function testValidateRejectsAllSamePattern(): void
    {
        $result = Vkn::validate('1111111111');

        self::assertFalse($result->valid);
        self::assertContains('Geçersiz örüntü: tüm haneler aynı.', $result->errors);
    }

    public function testValidateMultipleReturnsResultList(): void
    {
        $results = Vkn::validateMultiple([
            '1000036109',
            '1000036108',
            '1111111111',
        ]);

        self::assertCount(3, $results);
        self::assertTrue($results[0]->valid);
        self::assertFalse($results[1]->valid);
        self::assertFalse($results[2]->valid);
    }

    public function testValidateMultipleReturnsEmptyListForEmptyInput(): void
    {
        $results = Vkn::validateMultiple([]);

        self::assertSame([], $results);
    }
}
