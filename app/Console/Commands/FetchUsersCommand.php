<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\User\UserRepository;

class FetchUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch Users From Multiple Providers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        echo "------------------ Start Fetch Users ------------------------";
        
        $userRepository->fetchUsers();
        
        echo "------------------ End Fetch Users ------------------------";

    }
}
