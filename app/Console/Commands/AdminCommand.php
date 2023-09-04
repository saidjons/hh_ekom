<?php

namespace App\Console\Commands;

use App\Service\UserService;
use Illuminate\Console\Command;

class AdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make admin io email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user  = (new UserService)->find($email);
        if($user){
            $service = new UserService;
            $role =$service->getRole("admin");
            if(!$role){
                $role = $service->createAdminRole();
            }
            $user->assignRole($role);
            $this->info("{$email} is admin");
            return;
        }
        $this->warn("{$email} not found");
    }
}
