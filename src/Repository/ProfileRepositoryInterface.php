<?php


namespace App\Repository;


use App\Entity\Profile;

interface ProfileRepositoryInterface
{
    /**
     * @param Profile $profile
     * @return object
     */
    public function setCreateProfile(Profile $profile): object;

    /**
     * @param Profile $profile
     * @return object
     */
    public function setUpdateProfile(Profile $profile):  object;

    /**
     * @param string $email
     * @return object
     */
    public function getOneProfile(string $email): object;

    /**
     * @param string $id
     * @return Profile[]
     */
    public function getSearchProfile(string $id): array;
}