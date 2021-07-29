<?php
namespace App\Repositories\User;

use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use App\Services\UserFactory\UserProvider;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Services\UserFactory\ProviderX\ProviderXFactory;
use App\Services\UserFactory\ProviderY\ProviderYFactory;

class UserRepository
{
    /**
     * Fetch Users
     *
     * @return \Illuminate\Http\Response;
     */
    public function list()
    {
        // I Used Abstarct Factory Pattern to Allow us to add another Provider

        // Instaniate Pattern
        $provider = new UserProvider();

        $provider->setFactory(new ProviderXFactory());
        $provider->fetchUsers();

        dd("Done");
        
        $provider->setFactory(new ProviderYFactory());
        $provider->fetchUsers();
    }

}