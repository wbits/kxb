<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude(['vendor'])
    ->in(__DIR__);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules(
        [
            '@Symfony' => true,
            'binary_operator_spaces' => [
                'align_double_arrow' => false,
                'align_equals' => false,
            ],
            'concat_space' => ['spacing' => 'one'],
            'not_operator_with_successor_space' => false,
            'no_multiline_whitespace_before_semicolons' => true,
            'no_useless_else' => true,
            'no_useless_return' => true,
            'ordered_class_elements' => true,
            'ordered_imports' => true,
            'phpdoc_order' => true,
            'phpdoc_align' => false,
            'phpdoc_no_useless_inheritdoc' => true,
            'strict_comparison' => true,
            'strict_param' => true,
            'declare_equal_normalize' => [
                'space' => 'single',
            ],
        ]
    )
    ->setFinder($finder);
