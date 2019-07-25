<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Repository\Sql\User;

use ReflectionClass;
use Shared\Model\Domain\User\Email;
use Shared\Model\Domain\User\User;
use Shared\Model\Domain\User\UserRepository;
use Zend\Db\Adapter\Adapter;
use Zend\Hydrator\HydratorInterface;

class SqlUserRepository implements UserRepository
{

    /** @var \Zend\Db\Adapter\Adapter */
    private $db;

    /** @var \Zend\Hydrator\HydratorInterface */
    private $userHydrator;

    /**
     * @param \Zend\Db\Adapter\Adapter $db
     * @param \Zend\Hydrator\HydratorInterface $userHydrator
     */
    public function __construct(
        Adapter $db,
        HydratorInterface $userHydrator
    ) {
        $this->db = $db;
        $this->userHydrator = $userHydrator;
    }

    /**
     * @param int $id
     * @return \Shared\Model\Domain\User\User|null
     * @throws \ReflectionException
     */
    public function findById($id): ?User
    {
        $select = <<<SQL
            SELECT 
                User.*
            FROM User
            WHERE User.`idUser` = :idUser
            LIMIT 1
SQL;

        $statement = $this->db->createStatement($select);
        $queryResult = $statement->execute([
            ':idUser' => $id
        ]);

        if (! $queryResult->isQueryResult() || $queryResult->count() < 1) {
            return null;
        }

        $user = $this->instanciateUser();
        $this->userHydrator->hydrate($queryResult->current(), $user);

        return $user;
    }

    /**
     * @param \Shared\Model\Domain\User\Email $email
     * @return \Shared\Model\Domain\User\User|null
     * @throws \ReflectionException
     */
    public function findByEmail(Email $email): ?User
    {
        $select = <<<SQL
            SELECT 
                User.*
            FROM User
            WHERE User.`email` = :email
            LIMIT 1
SQL;

        $statement = $this->db->createStatement($select);
        $queryResult = $statement->execute([
            ':email' => $email->toString()
        ]);

        if (! $queryResult->isQueryResult() || $queryResult->count() < 1) {
            return null;
        }

        $instanciateUser = $this->instanciateUser();
        $this->userHydrator->hydrate($queryResult->current(), $instanciateUser);

        return $instanciateUser;
    }

    /**
     * @param \Shared\Model\Domain\User\User $user
     * @return mixed
     * @throws \ReflectionException
     */
    public function save(User $user)
    {
        if ($user->getId() !== null) {
            $this->update($user);
        } else {
            $this->insert($user);
        }
    }

    /**
     * @param User $user
     * @throws \ReflectionException
     */
    private function insert(User $user)
    {
        $insert = <<<SQL
            INSERT INTO `User` (
                role,
                status,
                firstname,
                lastname,
                displayName,
                email,
                password,
                creationDate,
                lastUpdateDate
            )
            VALUES (
                :role,
                :status,
                :firstname,
                :lastname,
                :displayName,
                :email,
                :password,
                :creationDate,
                :lastUpdateDate
            )
SQL;

        $extractedData = $this->userHydrator->extract($user);
        unset(
            $extractedData['idUser'],
            $extractedData['passwordHash']
        );

        $statement = $this->db->createStatement($insert);
        $statement->execute($extractedData);

        $this->injectGeneratedId($user);
    }

    /**
     * @param User $user
     */
    private function update(User $user)
    {
        $update = <<<SQL
            UPDATE `User`
            SET
                role = :role,
                status = :status,
                firstname = :firstname,
                lastname = :lastname,
                displayName = :displayName,
                email = :email,
                password = :password,
                creationDate = :creationDate,
                lastUpdateDate = :lastUpdateDate
            WHERE `idUser` = :idUser
SQL;

        $extractedData = $this->userHydrator->extract($user);
        unset(
            $extractedData['creationDate'],
            $extractedData['passwordHash']
        );

        $statement = $this->db->createStatement($update);
        $statement->execute($extractedData);
    }


    /**
     * @return \Shared\Model\Domain\User\User
     * @throws \ReflectionException
     */
    private function instanciateUser(): User
    {
        $reflectionClass = new ReflectionClass(User::class);
        return $reflectionClass->newInstanceWithoutConstructor();
    }

    /**
     * @param \Shared\Model\Domain\User\User $user
     * @throws \ReflectionException
     */
    private function injectGeneratedId(User $user)
    {
        $reflectionClass = new ReflectionClass($user);
        $idProperty = $reflectionClass->getProperty('id');
        $idProperty->setAccessible(true);
        $idProperty->setValue(
            $user,
            (int)$this->db->getDriver()->getLastGeneratedValue()
        );
    }

}