<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Action;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use League\OAuth2\Server\AuthorizationServer;
use OAuth2Server\Entity\User;

class AuthorizeActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthorizeAction(
            $container->get(AuthorizationServer::class),
            $container->get(EntityManager::class)->getRepository(User::class)
        );
    }
}
