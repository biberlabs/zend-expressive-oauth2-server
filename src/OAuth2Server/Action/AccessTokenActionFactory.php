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

class AccessTokenActionFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $server = $container->get(AuthorizationServer::class);
        return new AccessTokenAction($server);
    }
}
