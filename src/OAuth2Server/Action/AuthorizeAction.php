<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Action;

use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use OAuth2Server\Entity\Repository\UserRepository;
use OAuth2Server\Entity\User as UserEntity;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Stream;

class AuthorizeAction
{
    /**
     * @var \League\OAuth2\Server\AuthorizationServer
     */
    protected $server = null;

    protected $userRepository = null;

    public function __construct(AuthorizationServer $server, UserRepository $userRepository)
    {
        $this->server = $server;
        $this->userRepository = $userRepository;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null)
    {
        if ($request->getMethod() === 'GET') {
            $body = new Stream('php://temp', 'r+');
            $body->write($this->showUserLoginForm());

            return $response->withStatus(200)
                ->withBody($body)
                ->withHeader('Content-Type', 'text/html');
        } elseif ($request->getMethod() === 'POST') {


            $user = $this->userRepository->getUserEntityByUserCredentials(
                $request->getParsedBody()['username'],
                $request->getParsedBody()['password'],
                null,
                null
            );

            if (!$user) {
                return $response->withStatus(401);
            }
            try {
                // Validate the HTTP request and return an AuthorizationRequest object.
                // The auth request object can be serialized into a user's session
                $authRequest = $this->server->validateAuthorizationRequest($request);

                // Once the user has logged in set the user on the AuthorizationRequest
                $authRequest->setUser(new UserEntity());

                // Once the user has approved or denied the client update the status
                // (true = approved, false = denied)
                $authRequest->setAuthorizationApproved(true);

                // Return the HTTP redirect response
                return $this->server->completeAuthorizationRequest($authRequest, $response);
            } catch (OAuthServerException $exception) {
                return $exception->generateHttpResponse($response);
            } catch (\Exception $exception) {
                $body = new Stream('php://temp', 'r+');
                $body->write($exception->getMessage());

                return $response->withStatus(500)->withBody($body);
            }
        }
    }

    private function showUserLoginForm()
    {
        return '<form action="" method="post">
    <input type="text" name="username" placeholder="Username"/>
    <input type="text" name="password"  placeholder="Password"/>
    <input type="submit" value="Login" />
</form>';
    }
}
