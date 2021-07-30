<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\ApiValidationException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Traits\JsonResponseTrait;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Resources\Json\JsonResource;

class UsersController extends Controller
{
    use JsonResponseTrait;

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Search for hotels in many providers
     *
     * @return JsonResource
     */
    public function index(Request $request)
    {
        $data = $request->only('page');

        $response = $this->userRepository->list($data);

        // Return Data with JSON
        return $this->jsonResponse(200, 'Data Retrned Successfully', null, $response);
    }
    
    /**
     * Search for hotels in many providers
     *
     * @return JsonResource
     */
    public function search(Request $request)
    {
        $this->validatInputs($request);
        
        $data = $request->only(['page', 'firstName', 'lastName', 'email']);

        $response = $this->userRepository->search($data);

        // Return Data with JSON
        return $this->jsonResponse(200, 'Data Retrned Successfully', null, $response);
    }

    private function validatInputs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName' => 'nullable|string|min:1',
            'lastName' => 'nullable|string|min:1',
            'email' => 'nullable|email'
        ]);

        if ($validator->fails()) {
            throw new ApiValidationException($validator->errors()->messages());
        }
    }

}
