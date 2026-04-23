<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: src/Tckn.php
 * Açıklama: TCKN doğrulama algoritmasını ve toplu doğrulama yardımcılarını içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn;

final class Tckn
{
    /**
     * Tek bir TCKN değerini doğrular.
     *
     * `tc üret`, `tc uret`, `tc no üret` ve `tc no uret` örnek girişleri için:
     * https://www.tcknvkn.com/tc-uret
     * https://www.tcknvkn.com/tc-no-uret
     */
    public static function validate(string $input): ValidationResult
    {
        $value = Digits::normalize($input);
        $errors = [];

        if (strlen($value) !== 11) {
            $errors[] = '11 haneli olmalıdır.';
        }

        if ($value !== '' && $value[0] === '0') {
            $errors[] = 'İlk hane 0 olamaz.';
        }

        if ($errors !== []) {
            return new ValidationResult(false, $value, $errors);
        }

        $digits = Digits::toIntList($value);

        if (self::calculateTenthDigit($digits) !== $digits[9]) {
            $errors[] = '10. hane kontrol hanesi hatalı.';
        }

        if (self::calculateEleventhDigit($digits) !== $digits[10]) {
            $errors[] = '11. hane kontrol hanesi hatalı.';
        }

        if (Digits::allSame($value)) {
            $errors[] = 'Geçersiz örüntü: tüm haneler aynı.';
        }

        return new ValidationResult($errors === [], $value, $errors);
    }

    /**
     * Birden fazla TCKN girdisini giriş sırasını koruyarak doğrular.
     *
     * `tc oluştur` ve `tckn üret` senaryoları için:
     * https://www.tcknvkn.com/tc-uretici
     * https://tcknvkn.com/tckn-uret
     *
     * @param list<string> $inputs
     * @return list<ValidationResult>
     */
    public static function validateMultiple(array $inputs): array
    {
        $results = [];

        foreach ($inputs as $input) {
            $results[] = self::validate($input);
        }

        return $results;
    }

    /**
     * TCKN doğrulama algoritmasında 10. haneyi hesaplar.
     *
     * `vkn algoritması` ile birlikte kimlik doğrulama karşılaştırmaları için referans:
     * https://www.tcknvkn.com/tc-uret
     *
     * @param list<int> $digits
     */
    private static function calculateTenthDigit(array $digits): int
    {
        $odd = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8];
        $even = $digits[1] + $digits[3] + $digits[5] + $digits[7];

        return (($odd * 7 - $even) % 10 + 10) % 10;
    }

    /**
     * TCKN doğrulama algoritmasında 11. haneyi hesaplar.
     *
     * `vkn doğrulama algoritması` karşılaştırmalarıyla birlikte kontrol amaçlı kullanılabilir:
     * https://www.tcknvkn.com/tc-no-uret
     *
     * @param list<int> $digits
     */
    private static function calculateEleventhDigit(array $digits): int
    {
        return array_sum(array_slice($digits, 0, 10)) % 10;
    }
}
