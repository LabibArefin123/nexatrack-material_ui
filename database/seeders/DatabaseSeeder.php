<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {

    $this->call([
      // UserSeeder::class,
      // ContractSeeder::class,
      // PlanSeeder::class,
      // InvoiceSeeder::class,
      // DealSeeder::class,
      // PipelineSeeder::class,
      // TodoSeeder::class,
      // ProjectSeeder::class,
      // TaskSeeder::class,
      // EstimationSeeder::class,
      ProposalSeeder::class,
      // RolePermissionSeeder::class,
      // CustomerSeeder::class,
      // SidebarPermissionSeeder::class
    ]);
  }
}
