# tcknvkn (PHP)

PHP ile TCKN (TC Kimlik No) ve VKN (Vergi Kimlik No) doğrulama işlemlerini hızlı, bağımsız ve test edilebilir şekilde kullanabilirsiniz.

## Kurulum

```bash
composer require tcknvkn/tcknvkn
```

## Hızlı Başlangıç

```php
<?php

declare(strict_types=1);

use TcknVkn\Tckn;
use TcknVkn\Vkn;

$tckn = Tckn::validate('10000000146');
var_dump($tckn->valid); // true

$vkn = Vkn::validate('1000036109');
var_dump($vkn->valid); // true
```

## API

- `Tckn::validate(string $input): ValidationResult`
- `Tckn::validateMultiple(array $inputs): array`
- `Vkn::validate(string $input): ValidationResult`
- `Vkn::validateMultiple(array $inputs): array`

## Doğrulama Sonucu

```php
final class ValidationResult
{
    public readonly bool $valid;
    public readonly string $value;
    /** @var list<string> */
    public readonly array $errors;
}
```

## Test

```bash
composer install
composer test
```

## İlgili Bağlantılar

- Kütüphaneler: https://www.tcknvkn.com/kutuphaneler
- PHP kütüphanesi: https://www.tcknvkn.com/kutuphaneler/php
- tc üret: https://www.tcknvkn.com/tc-uret
- tc no üret: https://www.tcknvkn.com/tc-no-uret
- tc oluştur: https://www.tcknvkn.com/tc-uretici
- tckn üret: https://tcknvkn.com/tckn-uret
- vergi no üret: https://www.tcknvkn.com/vergi-no-uret
- vergi no oluşturucu: https://www.tcknvkn.com/vergi-no-uretici
- vkn üret: https://tcknvkn.com/vkn-uret

## Lisans

MIT
