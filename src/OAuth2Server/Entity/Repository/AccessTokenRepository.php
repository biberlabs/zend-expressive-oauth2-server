<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity\Repository;

use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use OAuth2Server\Entity\AccessToken as AccessTokenEntity;
use Doctrine\ORM\EntityRepository;
use OAuth2Server\Entity\Scope as ScopeEntity;
use OAuth2Server\Entity\User as UserEntity;

class AccessTokenRepository extends EntityRepository implements AccessTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        /**
         * @var AccessTokenEntity $accessTokenEntity
         */
        $user = null;
        if ($accessTokenEntity->getUserIdentifier()) {
            $this->_em->getRepository(UserEntity::class)
                ->findOneBy(['identifier' => $accessTokenEntity->getUserIdentifier()]);
        }

        $scopes = [];
        foreach ($accessTokenEntity->getScopes() as $scope) {
            /**
             * @var ScopeEntity $scope
             */
            //TODO: improve this area
            $scopes[] = $this->_em->getRepository(ScopeEntity::class)->find($scope->getIdentifier());
        }

        $accessTokenEntity->setScopes($scopes);
        $accessTokenEntity->setUserIdentifier($user);
        $this->_em->persist($accessTokenEntity);
        $this->_em->flush($accessTokenEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function revokeAccessToken($tokenId)
    {
        $token = $this->_em->find(AccessTokenEntity::class, $tokenId);
        $this->_em->remove($token);
        $this->_em->flush($token);
    }

    /**
     * {@inheritdoc}
     */
    public function isAccessTokenRevoked($tokenId)
    {
        $token = $this->_em->find(AccessTokenEntity::class, $tokenId);
        if ($token) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessTokenEntity();
        $accessToken->setClient($clientEntity);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        $accessToken->setUserIdentifier($userIdentifier);

        return $accessToken;
    }
}
