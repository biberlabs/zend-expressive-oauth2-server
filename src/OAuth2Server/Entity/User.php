<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use League\OAuth2\Server\Entities\UserEntityInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Server\Entity\Repository\UserRepository")
 * @ORM\Table(name="oauth_user")
 */
class User implements UserEntityInterface
{
    use EntityTrait;


    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=100)
     */
    protected $username;


    /**
     * @var string
     * @ORM\Column(name="password", type="string", length=100)
     */
    protected $password;

    public function __construct($identifier = null)
    {
        $this->username = '';
        $this->password = '';
        $this->setIdentifier($identifier);
    }

    /**
     * Return the user's identifier.
     *
     * @return mixed
     */
    public function getIdentifier()
    {
        return 1;
    }
}
