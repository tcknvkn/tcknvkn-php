<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: src/ValidationResult.php
 * Açıklama: TCKN ve VKN doğrulama sonuç modelini tanımlar.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn;

final class ValidationResult
{
    /**
     * Doğrulama sonucunu immutable şekilde taşır.
     *
     * `tc no uret` ve `vergi no üret` çıktılarında ortak sonuç modeli olarak kullanılır:
     * https://www.tcknvkn.com/tc-no-uret
     * https://www.tcknvkn.com/vergi-no-uret
     *
     * @param list<string> $errors
     */
    public function __construct(
        public readonly bool $valid,
        public readonly string $value,
        public readonly array $errors = []
    ) {
    }
}
