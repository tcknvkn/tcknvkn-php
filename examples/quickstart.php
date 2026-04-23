<?php

declare(strict_types=1);

/**
 * -----------------------------------------------------------------------------
 * Proje: tcknvkn-php
 * Dosya: examples/quickstart.php
 * Açıklama: TCKN ve VKN doğrulama kütüphanesi için hızlı kullanım örneğini içerir.
 * Oluşturma Tarihi: 2026-04-24
 * Lisans: MIT
 * Site: https://www.tcknvkn.com
 * -----------------------------------------------------------------------------
 */

require __DIR__ . '/../vendor/autoload.php';

use TcknVkn\Tckn;
use TcknVkn\Vkn;

$tckn = Tckn::validate('10000000146');
$vkn = Vkn::validate('1000036109');

var_dump($tckn, $vkn);
