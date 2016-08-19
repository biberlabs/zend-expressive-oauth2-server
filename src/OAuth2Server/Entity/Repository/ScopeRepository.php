<?php
/**
 * @author      Haydar KULEKCI <haydarkulekci@gmail.com>
 * @copyright   Copyright (c) Haydar KULEKCI
 * @license     http://mit-license.org/
 *
 * @link        https://github.com/biberlabs/zend-expressive-oauth2-server
 */

namespace OAuth2Server\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Repositories\ScopeRepositoryInterface;
use OAuth2Server\Entity\Scope as ScopeEntity;

class ScopeRepository extends EntityRepository implements ScopeRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getScopeEntityByIdentifier($scopeIdentifier)
    {
        $qb = $this->_em->createQueryBuilder();
        $qb->select('S');
        $qb->from(ScopeEntity::class, 'S')
            ->andWhere('S.identifier = :identifier')
            ->setParameter('identifier', $scopeIdentifier);
        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }

    /**
     * {@inheritdoc}
     */
    public function finalizeScopes(
        array $scopes,
        $grantType,
        ClientEntityInterface $clientEntity,
        $userIdentifier = null
    ) {
        // Example of programatically modifying the final scope of the access token
        if ((int) $userIdentifier === 1) {
            $scope = new ScopeEntity();
            $scope->setIdentifier('email');
            $scopes[] = $scope;
        }
        
        return $scopes;
    }
}
