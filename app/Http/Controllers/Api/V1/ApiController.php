<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\JsonResponseTrait;
use App\Repositories\User\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiController extends Controller
{
    use JsonResponseTrait;

    /**
     * Search for hotels in many providers
     *
     * @return JsonResource
     */
    public function getNewKey(Request $request)
    {
        $data = $request->only('name');

        if ( isset($data['name']) && $data['name'] == 'orcas') {
            $cipherKey = config('orcas.subscribe_key');
            $hashed = hash_hmac("sha256", "", $cipherKey);

            return $this->jsonResponse(200, 'Data Retrned Successfully', null, ['api_key'   => $hashed ]);
        }
        
        return $this->jsonResponse(200, 'Data are wrong', null, null);
    }
    
    /**
     * Search for hotels in many providers
     *
     * @return JsonResource
     */
    public function search(Request $request)
    {
        $request->validate([
            'firstName' =>  'required|string|min:1',
        ]);

        $data = $request->only(['page', 'firstName', 'lastName', 'email']);

        $response = $this->userRepository->search($data);

        // Return Data with JSON
        return $this->jsonResponse(200, 'Data Retrned Successfully', null, $response);
    }

}
