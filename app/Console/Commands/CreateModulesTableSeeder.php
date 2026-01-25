<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateModulesTableSeeder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:modules-seeder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate the ModulesTableSeeder file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $seederPath = database_path('seeders/ModulesTableSeeder.php');

        if (File::exists($seederPath)) {
            $this->error('ModulesTableSeeder.php already exists!');
            return Command::FAILURE;
        }

        $seederContent = <<<'EOD'
        <?php

        namespace Database\Seeders;

        use Illuminate\Database\Seeder;
        use Illuminate\Support\Facades\DB;

        class ModulesTableSeeder extends Seeder
        {
            /**
             * Run the database seeds.
             *
             * @return void
             */
            public function run()
            {
                DB::table('modules')->insert([
                    [
                        'name' => 'User Management',
                        'description' => 'Manage users and their roles.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Visitor Management',
                        'description' => 'Track and manage visitors.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Employee Management',
                        'description' => 'Handle employee records and attendance.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Report & Analytics',
                        'description' => 'Generate reports and analyze system data.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'System Settings',
                        'description' => 'Configure system preferences and settings.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Notifications and Alerts',
                        'description' => 'Manage notifications and alerts for users.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'name' => 'Roles and Permissions',
                        'description' => 'Assign roles and set permissions for users.',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    // Add more modules as needed
                ]);
            }
        }
        EOD;

        File::put($seederPath, $seederContent);

        $this->info('ModulesTableSeeder.php has been created successfully.');
        return Command::SUCCESS;
    }
}
