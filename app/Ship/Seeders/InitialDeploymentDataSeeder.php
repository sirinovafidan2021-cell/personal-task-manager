<?php

namespace App\Ship\Seeders;

use App\Containers\AppSection\TaskManagement\Data\Seeders\DevelopmentTaskSeeder;
use App\Ship\Parents\Seeders\Seeder;

final class InitialDeploymentDataSeeder extends Seeder
{
    /**
     * Note: This seeder is not loaded automatically by Apiato
     * This is a special seeder that can be called by "apiato:seed-deploy" command
     * It is useful for seeding data for initial deployment.
     */
    public function run(): void
    {
        if (!app()->environment('production')) {
            $this->call(DevelopmentTaskSeeder::class);
        }
    }
}
