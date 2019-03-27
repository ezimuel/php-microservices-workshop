<?php
declare(strict_types=1);

namespace App\User;

class UserEntity
{
    public $id;
    public $name;
    public $email;

    public function getArrayCopy()
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'email'    => $this->email,
        ];
    }

    public function exchangeArray(array $array)
    {
        if (isset($array['id'])) {
          $this->id = $array['id'];
        }
        if (isset($array['name'])) {
          $this->name = $array['name'];
        }
        if (isset($array['email'])) {
          $this->email = $array['email'];
        }
    }
}
