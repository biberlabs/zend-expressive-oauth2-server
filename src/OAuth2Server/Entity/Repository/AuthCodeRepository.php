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
use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use League\OAuth2\Server\Repositories\AuthCodeRepositoryInterface;
use OAuth2Server\Entity\AuthCode as AuthCodeEntity;
use OAuth2Server\Entity\User as UserEntity;

class AuthCodeRepository extends EntityRepository implements AuthCodeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAuthCode(AuthCodeEntityInterface $authCodeEntity)
    {
        /**
         * @var AuthCodeEntity $authCodeEntity
         */
        $user = $this->_em->getRepository(UserEntity::class)
            ->findOneBy(['identifier' => $authCodeEntity->getUserIdentifier()]);

        foreach ($authCodeEntity->getScopes() as $scope) {
            $this->_em->persist($scope);
        }

        $authCodeEntity->setUserIdentifier($user);
        $this->_em->persist($authCodeEntity);
        $this->_em->flush($authCodeEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAuthCode($codeId)
    {
        $token = $this->_em->find(AuthCodeEntity::class, $codeId);
        $this->_em->remove($token);
        $this->_em->flush($token);
    }

    /**
     * {@inheritdoc}
     */
    public function isAuthCodeRevoked($codeId)
    {
        $token = $this->_em->find(AuthCodeEntity::class, $codeId);
        if ($token) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewAuthCode()
    {
        return new AuthCodeEntity();
    }
}
