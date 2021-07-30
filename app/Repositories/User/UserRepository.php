<?php
namespace App\Repositories\User;

use Illuminate\Support\Facades\DB;
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
    public function list($data)
    {
        $paginationData = $this->paginate($data);

        return DB::select("SELECT * FROM users LIMIT {$paginationData['offset']}, {$paginationData['per_page']}");
    }
    
    /**
     * Fetch Users
     *
     * @return \Illuminate\Http\Response;
     */
    public function search($data)
    {
        $paginationData = $this->paginate($data);
        $stm = "SELECT * FROM users ";

        $stm = $this->prepareSqlFilters($stm, $data);
        
        $stm .= " LIMIT {$paginationData['offset']}, {$paginationData['per_page']}";

        return DB::select($stm);
    }

    /**
     * @param string $st
     * @param array $data
     * 
     * @return string
     */
    private function prepareSqlFilters(string $stm, array $data)
    {
        if (isset($data['firstName']) || isset($data['lastName']) || isset($data['email'])) {
            $stm .= " WHERE 1!=1 ";
        }

        if (isset($data['firstName']) && !empty($data['firstName'])) {
            $stm .= "OR first_name LIKE '%{$data['firstName']}%' ";
        }

        if (isset($data['lastName']) && !empty($data['lastName'])) {
            $stm .= "OR last_name LIKE '%{$data['lastName']}%' ";
        }

        if (isset($data['email']) && !empty($data['email'])) {
            $stm .= "OR email LIKE '%{$data['email']}%'";
        }

        return $stm;
    }
    
    
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


    /**
     * @param int $data
     * @param int $perPage
     * 
     * @return array
     */
    private function paginate($data)
    {
        $perPage = 10;
        $page = isset($data['page']) && !empty($data['page']) ? $data['page'] : 1;
        $offset = ($page - 1) * $perPage;
        
        return [
            'offset'    =>  $offset,
            'per_page'    =>  $perPage,
        ];
    }

}