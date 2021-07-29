<?php

namespace Tests\Unit;

use Tests\TestCase;


class UserTest extends TestCase
{

    public function testFetchAllUsers()
    {
        $this->getJson(route('list-all-users'))
            ->assertStatus(200)
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
