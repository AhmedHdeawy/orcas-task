<?php

namespace Tests\Unit;

use phpDocumentor\Reflection\Types\Parent_;
use Tests\TestCase;


class UserTest extends TestCase
{
    protected $headers;

    public function __construct()
    {
        parent::__construct();

        $this->headers = [ "api-key" => "ac36c76e565e853378d35075aa24bd8f52f4ce4fee69bb6b2451dd0d6cdb9035"];
    }

    public function testApiAuth()
    {
        $this->getJson(route('users.index'))
            ->assertStatus(401)
            ->assertJsonStructure([
                'message'
            ]);
    }
    
    public function testFetchAllUsers()
    {
        $this->getJson(route('users.index'), $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    0   =>  [
                        'first_name',
                        'last_name',
                        'email',
                        'avatar'
                    ]
                ]
            ]);
    }
    
    public function testUsersSearch()
    {
        $this->getJson(route('users.search'), $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    0   =>  [
                        'first_name',
                        'last_name',
                        'email',
                        'avatar'
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersFromProviderX()
    {
        $params = [
            'provider'  =>  'DataProviderX'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 4]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersFromProviderY()
    {
        $params = [
            'provider'  =>  'DataProviderY'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 6]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersWithAuthorisedStatus()
    {
        $params = [
            'statusCode'  =>  'authorised'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 3]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersWithDeclineStatus()
    {
        $params = [
            'statusCode'  =>  'decline'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 4]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }


    public function testFetchAllUsersWithRefundedStatus()
    {
        $params = [
            'statusCode'  =>  'refunded'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 3]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }


    public function testFetchAllUsersWithMinBalance()
    {
        $params = [
            'balanceMin'  =>  100
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 8]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersWithMaxBalance()
    {
        $params = [
            'balanceMax'  =>  190
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 6]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }

    public function testFetchAllUsersWithAmountRange()
    {
        $params = [
            'balanceMin'  =>  120,
            'balanceMax'  =>  320
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 5]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }


    public function testFetchAllUsersWithCurrency()
    {
        $params = [
            'currency'  =>  'AED'
        ];
        $this->getJson(route('list-all-users', $params))
            ->assertStatus(200)
            ->assertJson([
                'data'  =>  ['total'   => 2]
            ])
            ->assertJsonStructure([
                'status', 'message', 'errors',
                'data'  =>  [
                    'data'   => [
                        0   =>  [
                            'amount',
                            'currency',
                            'email',
                            'status_code',
                            'date',
                            'id',
                        ]
                    ]
                ]
            ]);
    }
}
