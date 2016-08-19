<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Server;

use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use League\OAuth2\Server\AuthorizationServer;
use OAuth2Server\Entity\AccessToken;
use OAuth2Server\Entity\Client;
use OAuth2Server\Entity\Scope;

class AuthorizationServerFactory
{
    protected $server;

    public function __invoke(ContainerInterface $container)
    {
        $config = $container->get('config');
        $authConfig = $config['oauth2'];

        $clientRepository = $container->get(EntityManager::class)
            ->getRepository(Client::class);
        $scopeRepository = $container->get(EntityManager::class)
            ->getRepository(Scope::class);
        $accessTokenRepository = $container->get(EntityManager::class)
            ->getRepository(AccessToken::class);

        //TODO: check for config existing
        $privateKeyPath = $authConfig['certificates']['private'];
        $publicKeyPath = $authConfig['certificates']['public'];

        // Setup the authorization server
        $this->server = new AuthorizationServer(
            $clientRepository,
            $accessTokenRepository,
            $scopeRepository,
            $privateKeyPath,
            $publicKeyPath
        );

        $this->enableGrantTypes($authConfig, $container);

        return $this->server;
    }

    private function enableGrantTypes($config, $container)
    {
        //TODO: Check Exiting of Keys
        if (isset($config['grants']['password'])) {
            $this->server->enableGrantType(
                $container->get($config['grants']['password']),
                new \DateInterval('PT1H') // access tokens will expire after 1 hour
            );
        }

        if (isset($config['grants']['refresh_token'])) {
            // Enable the refresh token grant on the server
            $this->server->enableGrantType(
                $container->get($config['grants']['refresh_token']),
                new \DateInterval('PT1H')
            );
        }

        if (isset($config['grants']['authorization_code'])) {
            // Enable the authentication code grant on the server with a token TTL of 1 hour
            $this->server->enableGrantType(
                $container->get($config['grants']['authorization_code']),
                new \DateInterval('PT1H')
            );
        }

        if (isset($config['grants']['client_credentials'])) {
            // Enable the client credentials grant on the server
            $this->server->enableGrantType(
                $container->get($config['grants']['client_credentials']),
                new \DateInterval('PT1H') // access tokens will expire after 1 hour
            );
        }
    }
}
