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
    protected $description = 'Run database migrations and seeders';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting database migrations...');

        // Run migrations
        $result = Artisan::call('migrate');
        $this->info('Migrations completed.');

        $this->info('Starting database seeding...');

        // Run seeding
        $result = Artisan::call('db:seed');
        $this->info('Database seeding completed.');

        Artisan::call('passport:client', ['--personal' => true, '--no-interaction' => true]);
    }
}
