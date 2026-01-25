<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class FetchUserModules extends Command
{
    protected $signature = 'user:modules {userId}';
    protected $description = 'Fetch all modules accessible to a user';

    public function handle()
    {
        $userId = $this->argument('userId');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found');
            return 1;
        }

        $modules = $user->allModules();
        $this->info('Accessible Modules:');
        $modules->each(fn($module) => $this->line('- ' . $module));

        return 0;
    }
}
