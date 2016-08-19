<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use Doctrine\ORM\PersistentCollection;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use OAuth2Server\Entity\User as UserEntity;
use Doctrine\ORM\Mapping as ORM;

trait TokenEntityTrait
{
    /**
     * @var \DateTime
     * @ORM\Column(name="expire_date", type="datetime", nullable=true)
     */
    protected $expiryDateTime;

    /**
     * @var UserEntity
     *
     * @ORM\ManyToOne(targetEntity="OAuth2Server\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="identifier", onDelete="SET NULL", nullable=true)
     */
    protected $userIdentifier;

    /**
     * @var ClientEntityInterface
     *
     * @ORM\ManyToOne(targetEntity="OAuth2Server\Entity\Client")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="identifier", onDelete="SET NULL", nullable=true)
     */
    protected $client;

    /**
     * Associate a scope with the token.
     *
     * @param ScopeEntityInterface $scope
     */
    public function addScope(ScopeEntityInterface $scope)
    {
        $this->scopes[$scope->getIdentifier()] = $scope;
    }

    public function setScopes($scopes)
    {
        $this->scopes = $scopes;
    }

    /**
     * Return an array of scopes associated with the token.
     *
     * @return ScopeEntityInterface[]
     */
    public function getScopes()
    {
        if (is_object($this->scopes) && $this->scopes instanceof PersistentCollection) {
            $this->scopes = (array)$this->scopes->getSnapshot();
        }
        return array_values($this->scopes);
    }

    /**
     * Get the token's expiry date time.
     *
     * @return \DateTime
     */
    public function getExpiryDateTime()
    {
        return $this->expiryDateTime;
    }

    /**
     * Set the date time when the token expires.
     *
     * @param \DateTime $dateTime
     */
    public function setExpiryDateTime(\DateTime $dateTime)
    {
        $this->expiryDateTime = $dateTime;
    }

    /**
     * Set the identifier of the user associated with the token.
     *
     * @param UserEntity $identifier The identifier of the user
     */
    public function setUserIdentifier($identifier)
    {
        $this->userIdentifier = $identifier;
    }

    /**
     * Get the token user's identifier.
     *
     * @return UserEntity
     */
    public function getUserIdentifier()
    {
        return $this->userIdentifier;
    }

    /**
     * Get the client that the token was issued to.
     *
     * @return ClientEntityInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set the client that the token was issued to.
     *
     * @param ClientEntityInterface $client
     */
    public function setClient(ClientEntityInterface $client)
    {
        $this->client = $client;
    }
}
