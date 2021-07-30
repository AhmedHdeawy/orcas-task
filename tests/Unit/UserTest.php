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

        $this->headers = ["api-key" => "ac36c76e565e853378d35075aa24bd8f52f4ce4fee69bb6b2451dd0d6cdb9035"];
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

    public function testUsersSearchWithFirstName()
    {
        $data = [
            'firstName' =>  'Aaron'
        ];

        $this->getJson(route('users.search', $data), $this->headers)
            ->assertStatus(200)
            ->assertJsonPath('data.0.first_name'    ,  'Aaron')
            ->assertJsonStructure([
                'status', 'message', 'errors','data'
            ]);

    }
    
    public function testUsersSearchWithLastName()
    {
        $data = [
            'lastName' =>  'Huel'
        ];

        $this->getJson(route('users.search', $data), $this->headers)
            ->assertStatus(200)
            ->assertJsonPath('data.0.last_name'    ,  'Huel')
            ->assertJsonStructure([
                'status', 'message', 'errors','data'
            ]);

    }
    
    public function testUsersSearchWithEmail()
    {
        $data = [
            'email' =>  'Electa.Sc54aefer@hotmail.com'
        ];

        $this->getJson(route('users.search', $data), $this->headers)
            ->assertStatus(200)
            ->assertJsonPath('data.0.email'    ,  'Electa.Sc54aefer@hotmail.com')
            ->assertJsonStructure([
                'status', 'message', 'errors','data'
            ]);

    }

}
