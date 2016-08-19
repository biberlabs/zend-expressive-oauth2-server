<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Middleware;

use Interop\Container\ContainerInterface;
use League\OAuth2\Server\Middleware\ResourceServerMiddleware;
use League\OAuth2\Server\ResourceServer;

class ResourceServerMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $server = $container->get(ResourceServer::class);

        return new ResourceServerMiddleware($server);
    }
}
