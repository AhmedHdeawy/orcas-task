<?php
namespace App\Repositories\User;


use App\Services\UserFactory\UserProvider;
use App\Services\UserFactory\ProviderX\ProviderXFactory;
use App\Services\UserFactory\ProviderY\ProviderYFactory;

class UserRepository
{
    /**
     * Fetch Users
     *
     * @return \Illuminate\Http\Response;
     */
    public function fetchUsers()
    {
        // I Used Abstarct Factory Pattern to Allow us to add another Provider

        // Instaniate Pattern
        $provider = new UserProvider();

        // If you need manage All Provideres from One Place Use:
        $this->handleAllProviders($provider);

        // If you need manage each Provider Individually Use:
        // $this->handleOneProviders($provider);

    }

    /**
     * @param UserProvider $provider
     * 
     * @return void
     */
    private function handleAllProviders(UserProvider $provider)
    {
        $providers = [
            new ProviderXFactory(),
            new ProviderYFactory(),
        ];
        
        foreach ($providers as $pro) {
            $provider->setFactory($pro);
            $provider->fetchUsers();
        }
    }
    
    /**
     * @param UserProvider $provider
     * 
     * @return void
     */
    private function handleOneProviders(UserProvider $provider)
    {
        // Save Users from First API (Provider X)
        $provider->setFactory(new ProviderXFactory());
        $provider->fetchUsers();

        // Save Users from Second API (Provider Y)
        $provider->setFactory(new ProviderYFactory());
        $provider->fetchUsers();
    }

}