<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use OAuth2Server\Entity\User;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

class UserRepository extends EntityRepository implements UserRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('U');
        $qb->from(User::class, 'U')
            ->andWhere('U.username = :username AND U.password = :password')
            ->setParameter('username', $username)
            ->setParameter('password', $password);
        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }
}
