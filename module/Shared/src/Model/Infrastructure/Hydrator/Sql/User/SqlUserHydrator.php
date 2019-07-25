<?php
/**
 * @package zf3-blog
 * @author Rtransat
 */

namespace Shared\Model\Infrastructure\Hydrator\Sql\User;

use DateTimeImmutable;
use Shared\Model\Domain\User\Email;
use Shared\Model\Domain\User\PasswordHash;
use Shared\Model\Domain\User\Role;
use Shared\Model\Domain\User\Status;
use Zend\Hydrator\HydratorInterface;
use Zend\Hydrator\NamingStrategy\MapNamingStrategy;
use Zend\Hydrator\ReflectionHydrator;

class SqlUserHydrator implements HydratorInterface
{

    /** @var \Zend\Hydrator\ReflectionHydrator */
    private $hydrator;

    /**
     *
     */
    public function __construct()
    {
        $this->hydrator = new ReflectionHydrator();
        $this->hydrator->setNamingStrategy(MapNamingStrategy::createFromHydrationMap(
            [
                'idUser' => 'id',
            ]
        ));
    }

    /**
     * @param \Zend\Hydrator\object $object
     * @return array
     */
    public function extract($object) : array
    {
        $data = $this->hydrator->extract($object);

        $data['role'] = Role::USER;
        $data['status'] = (string)$data['status']->toInt();
        $data['email'] = $data['email']->toString();
        $data['password'] = $data['passwordHash']->toString();
        $data['creationDate'] = $data['creationDate']->format('Y-m-d H:i:s');

        if ($data['lastUpdateDate'] !== null) {
            $data['lastUpdateDate'] = $data['lastUpdateDate']->format('Y-m-d H:i:s');
        }

        return $data;
    }

    /**
     * @param array $data
     * @param \Zend\Hydrator\object $object
     * @return object|\Zend\Hydrator\object
     */
    public function hydrate(array $data, $object)
    {
        $data['idUser'] = (int)$data['idUser'];
        $data['role'] = new Role((int)$data['role']);
        $data['status'] = new Status((int)$data['status']);
        $data['email'] = new Email($data['email']);
        $data['passwordHash'] = PasswordHash::fromHash($data['password']);
        $data['creationDate'] = DateTimeImmutable::createFromFormat(
            'Y-m-d H:i:s',
            $data['creationDate']
        );

        if ($data['lastUpdateDate'] !== null) {
            $data['lastUpdateDate'] = DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $data['lastUpdateDate']
            );
        }

        return $this->hydrator->hydrate($data, $object);
    }
}
