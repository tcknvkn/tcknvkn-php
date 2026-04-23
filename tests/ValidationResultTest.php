<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: tests/ValidationResultTest.php
 * Açıklama: ValidationResult modeli için birim testlerini içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn\Tests;

use PHPUnit\Framework\TestCase;
use TcknVkn\ValidationResult;

final class ValidationResultTest extends TestCase
{
    public function testConstructorAssignsReadonlyProperties(): void
    {
        $result = new ValidationResult(false, '123', ['hata']);

        self::assertFalse($result->valid);
        self::assertSame('123', $result->value);
        self::assertSame(['hata'], $result->errors);
    }
}
