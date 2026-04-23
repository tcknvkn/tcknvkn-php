<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: src/Vkn.php
 * Açıklama: VKN doğrulama algoritmasını ve toplu doğrulama yardımcılarını içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn;

final class Vkn
{
    /** @var list<int> */
    private const POWERS_OF_TWO = [512, 256, 128, 64, 32, 16, 8, 4, 2];

    /**
     * Tek bir VKN değerini doğrular.
     *
     * `vkn üret`, `vergi no üret` ve `vergi no oluşturucu` örnekleri için:
     * https://tcknvkn.com/vkn-uret
     * https://www.tcknvkn.com/vergi-no-uret
     * https://www.tcknvkn.com/vergi-no-uretici
     */
    public static function validate(string $input): ValidationResult
    {
        $value = Digits::normalize($input);
        $errors = [];

        if (strlen($value) !== 10) {
            $errors[] = '10 haneli olmalıdır.';
            return new ValidationResult(false, $value, $errors);
        }

        $digits = Digits::toIntList($value);

        if (self::calculateChecksum($digits) !== $digits[9]) {
            $errors[] = 'Son hane kontrol hanesi hatalı.';
        }

        if (Digits::allSame($value)) {
            $errors[] = 'Geçersiz örüntü: tüm haneler aynı.';
        }

        return new ValidationResult($errors === [], $value, $errors);
    }

    /**
     * Birden fazla VKN girdisini giriş sırasını koruyarak doğrular.
     *
     * `vergi no oluşturucu` ve `vkn üret` senaryoları için:
     * https://www.tcknvkn.com/vergi-no-uretici
     * https://tcknvkn.com/vkn-uret
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
     * VKN doğrulama algoritması için son kontrol hanesini hesaplar.
     *
     * `vkn algoritması` ve `vkn doğrulama algoritması` açıklamaları için:
     * https://www.tcknvkn.com/vergi-no-uret
     *
     * @param list<int> $digits
     */
    private static function calculateChecksum(array $digits): int
    {
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $tmp = ($digits[$i] + (9 - $i)) % 10;
            $res = ($tmp * self::POWERS_OF_TWO[$i]) % 9;

            if ($tmp !== 0 && $res === 0) {
                $res = 9;
            }

            $sum += $res;
        }

        return (10 - ($sum % 10)) % 10;
    }
}
