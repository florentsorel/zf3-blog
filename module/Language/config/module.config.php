<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Language;

return [
    'translator' => [
        'locale' => 'fr_FR',
        'translation_file_patterns' => [
            [
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../languages',
                'pattern'  => '%s.mo',
            ],
            [
                'type'     => 'phpArray',
                'base_dir' => __DIR__ . '/../languages/validator',
                'pattern'  => '%s.php'
            ],
        ],
    ],
];
