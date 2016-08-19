<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use League\OAuth2\Server\Entities\AuthCodeEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Server\Entity\Repository\AuthCodeRepository")
 * @ORM\Table(name="oauth_auth_code")
 */
class AuthCode implements AuthCodeEntityInterface
{
    use EntityTrait, TokenEntityTrait;

    /**
     * @var string|string[]
     * @ORM\Column(name="redirect_uri", type="string", length=100, nullable=true)
     */
    protected $redirectUri;

    /**
     * @var ScopeEntityInterface[]
     * @ORM\ManyToMany(targetEntity="OAuth2Server\Entity\Scope", inversedBy="authCodes")
     * @ORM\JoinTable(name="auth_code_scopes",
     *     joinColumns={@ORM\JoinColumn(name="scope_id", referencedColumnName="identifier")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="auth_code_scope_id", referencedColumnName="identifier")}
     *     )
     */
    protected $scopes = [];

    /**
     * @return string
     */
    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    /**
     * @param string $uri
     */
    public function setRedirectUri($uri)
    {
        $this->redirectUri = $uri;
    }
}
