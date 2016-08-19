<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity;

use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Entities\Traits\RefreshTokenTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="OAuth2Server\Entity\Repository\RefreshTokenRepository")
 * @ORM\Table(name="oauth_refresh_token")
 */
class RefreshToken implements RefreshTokenEntityInterface
{
    use RefreshTokenTrait, EntityTrait;
}
