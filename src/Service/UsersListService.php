<?php

namespace App\Service;

class UsersListService
{

    /**
     * @var array{ id: int, email: string, name: string, lastName: string }[]
     */
    private $users = [
        [
            'id' => 1,
            'email' => 'alex1rap.wen.ru@gmail.com',
            'name' => 'Oleksandr',
            'lastName' => 'Riabokin'
        ],
        [
            'id' => 2,
            'email' => 'dastars@spaces.ru',
            'name' => 'Maxim',
            'lastName' => ''
        ],
        [
            'id' => 3,
            'email' => 'darinkamelnyk98@gmail.com',
            'name' => 'Dasha',
            'lastName' => ''
        ],
        [
            'id' => 4,
            'email' => 'test@test.com',
            'name' => 'Test',
            'lastName' => 'User'
        ],
    ];

    /**
     * @param string $email
     * @return bool
     */
    public function find(string $email): bool
    {
        foreach ($this->users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }
        return false;
    }
}
