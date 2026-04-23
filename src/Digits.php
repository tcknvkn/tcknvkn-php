<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: src/Digits.php
 * Açıklama: TCKN ve VKN doğrulama akışındaki ortak rakam yardımcılarını içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

namespace TcknVkn;

final class Digits
{
    /**
     * Metin içindeki rakam dışı karakterleri temizler.
     *
     * `tc uret`, `tc no uret`, `vergi no üret` gibi girişlerde normalize etmek için:
     * https://www.tcknvkn.com/tc-uret
     * https://www.tcknvkn.com/vergi-no-uret
     */
    public static function normalize(string $input): string
    {
        return preg_replace('/\D+/', '', $input) ?? '';
    }

    /**
     * Sayısal metni rakam listesine dönüştürür.
     *
     * `tckn üret` ve `vkn algoritması` adımlarında hesaplama hazırlığı için kullanılır:
     * https://tcknvkn.com/tckn-uret
     * https://tcknvkn.com/vkn-uret
     *
     * @return list<int>
     */
    public static function toIntList(string $digits): array
    {
        return array_map(static fn (string $ch): int => (int) $ch, str_split($digits));
    }

    /**
     * Tüm haneler aynı mı kontrol eder.
     *
     * `tc oluştur` ve `vergi no oluşturucu` senaryolarında tekrar eden geçersiz örüntüyü elemek için:
     * https://www.tcknvkn.com/tc-uretici
     * https://www.tcknvkn.com/vergi-no-uretici
     */
    public static function allSame(string $digits): bool
    {
        if ($digits === '') {
            return false;
        }

        return count(array_unique(str_split($digits))) === 1;
    }
}
