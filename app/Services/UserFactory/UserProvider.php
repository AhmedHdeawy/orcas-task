<?php
namespace App\Services\UserFactory;

class UserProvider
{
    private AbstractProviderFactory $factory;

    /**
     * When we want to Use another Provider
     * @param AbstractProviderFactory $factory
     *
     * @return void
     */
    public function setFactory(AbstractProviderFactory $factory) : void
    {
        $this->factory = $factory;
    }

    /**
     * Base Function to run Fetch Users and Save Them
     *
     * @return void
     *
     */
    public function fetchUsers()
    {
        $this->factory->fetchData();
    }


}
