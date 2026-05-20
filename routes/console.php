<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('legacy:import-sqlite', function () {
    $sqlitePath = database_path('database.sqlite');

    if (! file_exists($sqlitePath)) {
        $this->error("SQLite database not found at {$sqlitePath}");
        return self::FAILURE;
    }

    config([
        'database.connections.sqlite_legacy' => [
            'driver' => 'sqlite',
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => false,
        ],
    ]);

    $legacy = DB::connection('sqlite_legacy');
    $mysql = DB::connection(config('database.default'));

    $tables = [
        'users',
        'company_settings',
        'services',
        'service_details',
        'logos',
        'blogs',
        'service_requests',
    ];

    $mysql->statement('SET FOREIGN_KEY_CHECKS=0');

    try {
        foreach ($tables as $table) {
            $legacyColumns = Schema::connection('sqlite_legacy')->getColumnListing($table);
            $mysqlColumns = Schema::connection(config('database.default'))->getColumnListing($table);
            $columns = array_values(array_intersect($legacyColumns, $mysqlColumns));

            if (empty($columns)) {
                $this->warn("Skipped {$table}: no shared columns found.");
                continue;
            }

            $rows = $legacy->table($table)->select($columns)->get()
                ->map(fn ($row) => (array) $row)
                ->all();

            $mysql->table($table)->delete();

            if (empty($rows)) {
                $this->line("{$table}: 0 rows");
                continue;
            }

            foreach (array_chunk($rows, 100) as $chunk) {
                $mysql->table($table)->insert($chunk);
            }

            $this->info("{$table}: imported ".count($rows).' rows');
        }
    } finally {
        $mysql->statement('SET FOREIGN_KEY_CHECKS=1');
    }

    return self::SUCCESS;
})->purpose('Import legacy app data from database/database.sqlite into the configured database');
