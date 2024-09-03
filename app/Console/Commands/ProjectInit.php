<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ProjectInit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:project-init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run Project Init';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('Running migration and seeder...');
        Artisan::call('migrate:refresh --seed');
        $this->info('Running migration and seeder done.');

        $this->info('Running optimize clear...');
        Artisan::call('optimize:clear');
        $this->info('Running optimize clear done.');

        $this->info('Running storage link...');
        Artisan::call('storage:link');
        $this->info('Running storage link done.');

        $this->info('Running passport keys...');
        Artisan::call('passport:keys --force');
        $this->info('Running passport keys done.');

        $this->info('Running passport client...');
        Artisan::call('passport:client', ['--personal' => true, '--no-interaction' => true]);
        $this->info('Running passport client done.');

        // migration
        // seeder
    }
}
