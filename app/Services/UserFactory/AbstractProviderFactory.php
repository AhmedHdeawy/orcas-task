<?php
namespace App\Services\UserFactory;

use Illuminate\Support\Collection;

interface AbstractProviderFactory
{
    /**
     * Fetch User Data
     *
     * @return void $response
     */
    public function fetchData();
    
    /**
     * Call Provider API
     *
     * @return void $response
     */
    public function callApi();

    /**
     * format and Validate Response
     *
     * @return void
     */
    public function handleData();

    /**
     * format and Validate Response
     * * @param array $item
     *
     * @return array $result
     */
    public function reFromateItem(array $item);

}
