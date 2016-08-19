<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Server\Entity\Repository\ClientRepository")
 * @ORM\Table(name="oauth_client")
 */
class Client implements ClientEntityInterface
{
    use EntityTrait;

    /**
     * @var string
     * @ORM\Column(name="secret", type="string", length=200, nullable=true)
     */
    protected $secret;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=100)
     */
    protected $name;

    /**
     * @var string|string[]
     * @ORM\Column(name="redirect_uri", type="string", length=100)
     */
    protected $redirectUri;

    /**
     * @var string|string[]
     * @ORM\Column(name="is_confidential", type="boolean", length=100)
     */
    protected $confidential;

    /**
     * Get the client's name.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the registered redirect URI (as a string).
     *
     * Alternatively return an indexed array of redirect URIs.
     *
     * @return string|string[]
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }

    public function getSecret()
    {
        return $this->secret;
    }

    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    public function isConfidential()
    {
        return $this->confidential;
    }

    public function setConfidential($confidential)
    {
        $this->confidential = $confidential;
    }
}
