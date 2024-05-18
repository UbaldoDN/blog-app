<?php

use PhpCsFixer\Config;
use PhpCsFixer\Finder;
use PhpCsFixer\Runner\Parallel\ParallelConfigFactory;

return (new Config())
    ->setParallelConfig(ParallelConfigFactory::detect())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => true,
        'no_unused_imports' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => true,
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => [
            'default' => 'align_single_space_minimal'
        ],
        'blank_line_before_statement' => [
            'statements' => ['return']
        ],
    ])
    ->setFinder((new Finder())
        ->in(['app', 'tests'])
        ->name('*.php')
        ->notName('*.blade.php')
        ->exclude('vendor')
        ->exclude('storage')
        ->exclude('bootstrap')
    );