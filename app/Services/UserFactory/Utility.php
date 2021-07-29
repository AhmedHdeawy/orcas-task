<?php

namespace App\Services\UserFactory;

use App\Exceptions\UrlException;
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
     * @return string
     */
    public function prepareForSaving(array $data)
    {
        $st = $this->concatenateText($data['first_name'], ",");
        $st .= $this->concatenateText($data['last_name'], ",");
        $st .= $this->concatenateText($data['email'], ",");
        $st .= $this->concatenateText($data['avatar']);
        
        return $st;
    }

    public function concatenateText(string $string, $last = '')
    {
        return '"'. $string . '"' . $last;
    }
    
    
    /**
     * @param array $data
     * 
     * @return bool
     */
    public function saveUserData(array $data)
    {
        
        $sqlStm = implode(",", $data);
        $this->saveUsingDB($sqlStm);

        // $this->saveUsingEloquent($data);

        return true;
    }

    /**
     * @param string $data
     * 
     * @return void
     */
    public function saveUsingDB(string $data)
    {
        DB::select("INSERT INTO `users`(`first_name`, `last_name`, `avatar`, `email`) VALUES {$data}");

        // DB::insert(
        //     'insert into users (first_name, last_name, email, avatar, created_at, updated_at) values (?, ?, ?, ?, ?, ?)',
        //     [
        //         $data['first_name'],
        //         $data['last_name'],
        //         $data['email'],
        //         $data['avatar'],
        //         now(),
        //         now(),
        //     ]
        // );
    }
    /**
     * @param array $data
     * 
     * @return void
     */
    public function saveUsingEloquent(array $data)
    {
        User::create([
            $data['first_name'],
            $data['last_name'],
            $data['email'],
            $data['avatar'],
        ]);
    }
}
