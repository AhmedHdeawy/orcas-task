<?php

namespace App\Services\UserFactory;

use App\User;
use Illuminate\Support\Facades\DB;

trait Utility
{

    /**
     * @param mixed $url
     * @param string $type
     * @param mixed $data
     * @param array $headers
     * 
     * @return mixed|bool
     */
    public function requestUsingCurl($url, $type = 'GET', $data = null, $headers = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $type == 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        return $result;
    }


    /**
     * @param array $data
     * 
     * @return bool
     */
    public function validateData(array $data)
    {
        if (!isset($data['first_name']) || empty($data['first_name'])) {
            return false;
        }

        if (!isset($data['last_name']) || empty($data['last_name'])) {
            return false;
        }

        if (!isset($data['avatar']) || empty($data['avatar'])) {
            return false;
        }

        if (!isset($data['email']) || empty($data['email'])) {
            return false;
        }

        if (DB::table('users')->where('email', $data['email'])->first()) {
            return false;
        }

        return true;
    }

    /**
     * @param array $data
     * 
     * @return bool
     */
    public function saveUserData(array $data)
    {
        $this->saveUsingDB($data);

        // $this->saveUsingEloquent($data);

        return true;
    }

    /**
     * @param array $data
     * 
     * @return void
     */
    public function saveUsingDB(array $data)
    {
        DB::table('users')->insert($data);
    }
    /**
     * @param array $data
     * 
     * @return void
     */
    public function saveUsingEloquent(array $data)
    {
        User::insert($data);
    }
}
