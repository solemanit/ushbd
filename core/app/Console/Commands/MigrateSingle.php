<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateSingle extends Command
{
    protected $signature = 'migrate:single {file}';
    protected $description = 'Run a specific migration file manually';

    public function handle()
    {
        $file = $this->argument('file');
        $path = database_path('migrations/' . $file);

        if (!file_exists($path)) {
            $this->error("Migration file '{$file}' does not exist.");
            return 1;
        }

        // Load and evaluate the migration file, return anonymous class
        $migration = require $path;

        if (!is_object($migration)) {
            $this->error("Migration did not return an object.");
            return 1;
        }

        if (!method_exists($migration, 'up')) {
            $this->error("Migration object has no 'up' method.");
            return 1;
        }

        $migration->up();

        DB::table('migrations')->insert([
            'migration' => str_replace('.php', '', $file),
            'batch' => DB::table('migrations')->max('batch') + 1,
        ]);

        $this->info("Migration '{$file}' ran successfully.");
        return 0;
    }
}
