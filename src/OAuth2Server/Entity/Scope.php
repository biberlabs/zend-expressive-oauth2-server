<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use League\OAuth2\Server\Entities\ScopeEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Server\Entity\Repository\ScopeRepository")
 * @ORM\Table(name="oauth_scope")
 */
class Scope implements ScopeEntityInterface
{
    use EntityTrait;

    /**
     * @ORM\ManyToMany(targetEntity="OAuth2Server\Entity\AccessToken", mappedBy="scopes")
     */
    private $accessTokens;

    /**
     * @ORM\ManyToMany(targetEntity="OAuth2Server\Entity\AuthCode", mappedBy="scopes")
     */
    private $authCodes;

    public function jsonSerialize()
    {
        return $this->getIdentifier();
    }
}
