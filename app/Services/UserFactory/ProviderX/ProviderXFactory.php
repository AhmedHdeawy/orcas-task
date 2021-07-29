<?php
namespace App\Services\UserFactory\ProviderX;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\UserFactory\Utility;
use App\Services\UserFactory\AbstractProviderFactory;

class ProviderXFactory implements AbstractProviderFactory
{
    use Utility;

    private array $users;
    private string $url = '';

    public function __construct()
    {
        $this->url = config('endpoints.provider_x');
    }

    /**
     * Fetch User Data
     *
     * @return void $response
     */
    public function fetchData() : void
    {
        // 1- Call API
        $this->callApi();

        // 2- Handle Data
        $this->handleData();
    }
   

	/**
	 * Get Data from Api 
	 *
	 *
	 * @return void|bool
	 */
	public function callApi()
    {
        // Call URL
        $fetchUsers = $this->requestUsingCurl($this->url);
        
        if (!$fetchUsers) {
            return false;
        }
        // Get Data in array format
        $this->users = json_decode($fetchUsers, true);
    }

    /**
     * Listing Process
     *
     * @return array
     */
    public function handleData(): array
    {
        $usersToSave = [];
        foreach ($this->users as $user) {
            // Reformate Item
            $user = $this->reFromateItem($user);
            // Check Data Validation
            $validate = $this->validateData($user);
            // In case the data not valid, then ignore this USER
            if (!$validate) {
                continue;
            }

            $stm = $this->prepareForSaving($user);

            $usersToSave[] = $stm;
        }

        // Save All Filtered Users at Once
        $this->saveUserData($usersToSave);

        return [];
    }
    
    
    /**
     * @param array $item
     * 
     * @return array
     */
    public function reFromateItem(array $item): array
    {
        return [
            'first_name'    =>  $item['firstName'] ?? '',
            'last_name'     =>  $item['lastName'] ?? '',
            'email'         =>  $item['email'] ?? '',
            'avatar'        =>  $item['avatar'] ?? '',
        ];
    }
}
