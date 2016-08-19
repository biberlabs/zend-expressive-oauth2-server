<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Grant;

use Interop\Container\ContainerInterface;
use League\OAuth2\Server\Grant\PasswordGrant;
use OAuth2Server\Entity\RefreshToken;
use OAuth2Server\Entity\User;
use Doctrine\ORM\EntityManager;

class PasswordGrantFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $grant = new PasswordGrant(
            $container->get(EntityManager::class)->getRepository(User::class),           // instance of UserRepositoryInterface
            $container->get(EntityManager::class)->getRepository(RefreshToken::class)    // instance of RefreshTokenRepositoryInterface
        );
        $grant->setRefreshTokenTTL(new \DateInterval('P1M')); // refresh tokens will expire after 1 month

        return $grant;
    }
}
