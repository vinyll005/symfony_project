<?php

namespace App\Repository;

interface UserRepositoryInterface
{
    /**
     * @param int $userId
     * @return object
     */
    public function getOne(int $userId): object;

    /**
     * @return array
     */
    public function getAll(): array;

    /**
     * @param User $user
     * @return object
     */
    public function setCreateUser(User $user): object;

    /**
     * @param User $user
     * @return object
     */
    public function setUpdateUser(User $user): object;

    /**
     * @param User $user
     * @return mixed
     */
    public function setDeleteUser(User $user);
}