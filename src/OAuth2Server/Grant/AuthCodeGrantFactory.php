<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Grant;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use League\OAuth2\Server\Grant\AuthCodeGrant;
use OAuth2Server\Entity\AuthCode;
use OAuth2Server\Entity\RefreshToken;

class AuthCodeGrantFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $authCodeRepository = $container->get(EntityManager::class)->getRepository(AuthCode::class);
        $refreshTokenRepository = $container->get(EntityManager::class)->getRepository(RefreshToken::class);

        return new AuthCodeGrant(
            $authCodeRepository,
            $refreshTokenRepository,
            new \DateInterval('PT10M')
        );
    }
}
