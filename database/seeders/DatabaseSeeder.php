<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            AclSeeder::class,
            ComplaintWorkflowSeeder::class,
            ComplaintQuestionSeeder::class,
            ComplaintDemoSeeder::class,
        ]);
    }
}
