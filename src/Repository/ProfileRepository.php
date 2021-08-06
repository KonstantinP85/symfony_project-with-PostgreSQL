<?php

namespace App\Repository;

use App\Entity\Profile;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Profile|null find($id, $lockMode = null, $lockVersion = null)
 * @method Profile|null findOneBy(array $criteria, array $orderBy = null)
 * @method Profile[]    findAll()
 * @method Profile[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfileRepository extends ServiceEntityRepository implements ProfileRepositoryInterface
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct($registry, Profile::class);
    }

    public function setCreateProfile(Profile $profile): object
    {
        $this->manager->persist($profile);
        $this->manager->flush();
        return $profile;
    }

    public function setUpdateProfile(Profile $profile):  object
    {
        $this->manager->flush();
        return $profile;
    }

    public function getOneProfile(string $email): object
    {
        return parent::find($email);
    }

    public function getSearchProfile(string $id): array
    {
        return parent::findBy(
            ['language' => "$id"],
            ['id' => 'ASC']);
    }
}
