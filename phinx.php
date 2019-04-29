<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

require __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::create('config');
$dotenv->overload();

return [
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migration',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seed',
    ],
    'environments' => [
        'default_database' => 'local',
        'default_migration_table' => 'migration',
        'local' => [
            'adapter' => 'mysql',
            'host' => getenv('DB_HOST'),
            'name' => getenv('DB_NAME'),
            'user' => getenv('DB_USERNAME'),
            'pass' => getenv('DB_PASSWORD'),
            'port' => 3306,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_general_ci',
        ],
    ],
];
