<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'production' => [
            'adapter' => 'sqlite',
            'name' => './db/veterans',
            'suffix' => '.sqlite3',
        ],
        'development' => [
            'adapter' => 'sqlite',
            'name' => './tests/veterans',
            'suffix' => '.sqlite3',
        ],
    ],
    'version_order' => 'creation'
];
