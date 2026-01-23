<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/tests',
    ]);

    $rectorConfig->skip([
        __DIR__.'/vendor',
        __DIR__.'/bootstrap/cache',
        __DIR__.'/storage',
    ]);

    $rectorConfig->import(__DIR__.'/vendor/pekral/rector-rules/rector.php');
};
