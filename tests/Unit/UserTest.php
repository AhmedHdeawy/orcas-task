<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use App\Services\UserFactory\UserProvider;
use phpDocumentor\Reflection\Types\Parent_;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Services\UserFactory\ProviderX\ProviderXFactory;
use App\Services\UserFactory\ProviderY\ProviderYFactory;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    
    protected $headers;

    public function __construct()
    {
        parent::__construct();
        
        $this->headers = ["api-key" => "ac36c76e565e853378d35075aa24bd8f52f4ce4fee69bb6b2451dd0d6cdb9035"];
    }
    
    public function testFetchUsersFromProviderX()
    {        
        $provider = new UserProvider();
        $provider->setFactory(new ProviderXFactory());
        $provider->fetchUsers();

        $this->assertDatabaseCount('users', 100);
        $this->assertDatabaseHas('users', ['id' => 1]);
    }

    public function testFetchUsersFromProviderY()
    {        
        $provider = new UserProvider();
        $provider->setFactory(new ProviderYFactory());
        $provider->fetchUsers();

        $this->assertDatabaseCount('users', 100);
        $this->assertDatabaseHas('users', ['id' => 1]);
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
        $this->fillData();

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
        $this->fillData();

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
        $this->fillData();

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
        $this->fillData();
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
        $this->fillData();

        $data = [
            'email' =>  'Fletcher.Barton@yahoo.com'
        ];

        $this->getJson(route('users.search', $data), $this->headers)
            ->assertStatus(200)
            ->assertJsonPath('data.0.email'    ,  'Fletcher.Barton@yahoo.com')
            ->assertJsonStructure([
                'status', 'message', 'errors','data'
            ]);

    }

    private function fillData()
    {
        $provider = new UserProvider();
        $provider->setFactory(new ProviderXFactory());
        $provider->fetchUsers();
    }

}
