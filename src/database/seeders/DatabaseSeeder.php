<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        $this->command->info('Database seeded successfully.');

        $parameters = [
            '--personal' => true,
            '--name' => 'Client 1', // You can customize the client name here
        ];

        // Run the command
        Artisan::call('passport:client', $parameters);
    }
}
