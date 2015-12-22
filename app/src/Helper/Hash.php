<?php
namespace App\Helper;

/**
* 
*/
class Hash 
{
	
	protected $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function password($password)
    {
        $config = $this->config;
        return password_hash(
            $password,
            $config['hash']['algo'],
            ['cost' => $config['hash']['cost']]
        );
    }

    public function passwordCheck($password, $hash)
    {
        return password_verify($password, $hash);
    }
}