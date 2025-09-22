<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
// regras usadas no skip
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return static function (RectorConfig $rectorConfig): void {
    /*
     |------------------------------------------------------------
     | Alvos (onde o Rector vai atuar)
     |------------------------------------------------------------
     */
    $rectorConfig->paths([
        __DIR__.'/app',
        __DIR__.'/database',
        __DIR__.'/routes',
        __DIR__.'/config',
        // __DIR__ . '/tests',
    ]);

    $rectorConfig->parallel();
    $rectorConfig->cacheDirectory(__DIR__.'/.rector-cache');
    $rectorConfig->fileExtensions(['php']);
    $rectorConfig->autoloadPaths([__DIR__.'/vendor/autoload.php']);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_84,
        SetList::CODE_QUALITY,
        SetList::TYPE_DECLARATION,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
    ]);

    // Sets Laravel se o pacote estiver instalado
    $laravelSetClass = 'RectorLaravel\\Set\\LaravelSetList';
    if (class_exists($laravelSetClass)) {
        $laravelSets = [];
        foreach ([
            'LARAVEL_110', 'LARAVEL_100', 'LARAVEL_90',
            'LARAVEL_CODE_QUALITY', 'LARAVEL_STATIC_TO_INJECTION',
        ] as $const) {
            $fqn = $laravelSetClass.'::'.$const;
            if (defined($fqn)) {
                $laravelSets[] = constant($fqn);
            }
        }
        if ($laravelSets !== []) {
            $rectorConfig->sets($laravelSets);
        }
    }

    // Importar nomes (use ...) automaticamente
    $rectorConfig->importNames();

    // Em algumas versões existe este toggler; se existir, desative import de "short classes"
    if (method_exists($rectorConfig, 'importShortClasses')) {
        $rectorConfig->importShortClasses(false);
    }

    // Skip
    $rectorConfig->skip([
        __DIR__.'/vendor/*',
        __DIR__.'/storage/*',
        __DIR__.'/bootstrap/*',
        __DIR__.'/database/migrations/*',
        __DIR__.'/public/*',
    ]);
};
