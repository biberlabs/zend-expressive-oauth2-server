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
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Repositories\RefreshTokenRepositoryInterface;
use OAuth2Server\Entity\RefreshToken as RefreshTokenEntity;
use OAuth2Server\Entity\RefreshToken;

class RefreshTokenRepository extends EntityRepository implements RefreshTokenRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function persistNewRefreshToken(RefreshTokenEntityInterface $refreshTokenEntity)
    {
        /**
         * @var RefreshToken $refreshTokenEntity
         */
        $this->_em->persist($refreshTokenEntity);
        $this->_em->flush($refreshTokenEntity);
    }

    /**
     * {@inheritdoc}
     */
    public function revokeRefreshToken($tokenId)
    {
        //TODO: $this->_em->remove()
    }

    /**
     * {@inheritdoc}
     */
    public function isRefreshTokenRevoked($tokenId)
    {
        $token = $this->_em->find(RefreshTokenEntity::class, $tokenId);
        if ($token) {
            return false;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewRefreshToken()
    {
        return new RefreshTokenEntity();
    }
}
