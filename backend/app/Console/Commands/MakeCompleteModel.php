<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeCompleteModel extends Command
{
    protected $signature = 'make:completemodel {name}';
    protected $description = 'Create model, migration, controller, and seeder with custom directories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $modelPath = "Master/{$name}";
        $controllerPath = "Admin/Master/{$name}Controller";
        $migrationName = "create_".strtolower($name)."_table";
        $seederName = "{$name}Seeder";

        // Create Model with Migration
        Artisan::call("make:model {$modelPath} -m");

        // Create Controller
        Artisan::call("make:controller {$controllerPath} --model={$modelPath}");

        // Create Seeder
        Artisan::call("make:seeder {$seederName}");

        $this->info("Model, Migration, Controller, and Seeder for {$name} created successfully.");
    }
}
