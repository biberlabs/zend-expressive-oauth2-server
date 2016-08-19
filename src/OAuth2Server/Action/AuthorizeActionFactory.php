<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Action;

use Interop\Container\ContainerInterface;
use League\OAuth2\Server\AuthorizationServer;

class AuthorizeActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthorizeAction($container->get(AuthorizationServer::class));
    }
}
