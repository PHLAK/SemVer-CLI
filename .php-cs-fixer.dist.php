<?php

require __DIR__ . '/vendor/autoload.php';

$finder = PhpCsFixer\Finder::create()->in([
    __DIR__ . DIRECTORY_SEPARATOR . 'bin',
    __DIR__ . DIRECTORY_SEPARATOR . 'src',
    __DIR__ . DIRECTORY_SEPARATOR . 'tests',
]);

return PHLAK\CodingStandards\ConfigFactory::make($finder, [
    'php_unit_set_up_tear_down_visibility' => true,
    'php_unit_test_annotation' => [
        'style' => 'annotation',
    ],
])->setRiskyAllowed(true);
