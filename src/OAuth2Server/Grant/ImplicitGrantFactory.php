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
use League\OAuth2\Server\Grant\ImplicitGrant;

class ImplicitGrantFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ImplicitGrant(
            new \DateInterval('PT1H')
        );
    }
}
