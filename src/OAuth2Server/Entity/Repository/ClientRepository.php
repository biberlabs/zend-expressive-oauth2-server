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
use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use OAuth2Server\Entity\Client as ClientEntity;
use OAuth2Server\Entity\Client;

class ClientRepository extends EntityRepository implements ClientRepositoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $clients = [
            'myawesomeapp' => [
                'secret'          => password_hash('whisky', PASSWORD_BCRYPT),
                'name'            => 'My Awesome App',
                'redirect_uri'    => 'http://foo/bar',
                'is_confidential' => true,
            ],
        ];

        $qb = $this->_em->createQueryBuilder();
        $qb->select('C');
        $qb->from(ClientEntity::class, 'C')
            ->andWhere('C.identifier = :identifier')
            ->setParameter('identifier', $clientIdentifier);
        $query = $qb->getQuery();

        /**
         * @var ClientEntity $client
         */
        $client = $query->getOneOrNullResult();

        if ($mustValidateSecret === true
            && $client->isConfidential() === true
            && password_verify($clientSecret, $client->getSecret()) === false
        ) {
            return;
        }

        return $client;
    }
}
