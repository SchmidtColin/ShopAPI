<?php

namespace ShopBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * shop_reviewsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class shop_reviewsRepository extends EntityRepository
{

    private function getShop(int $shopId, string $password)
    {
        return $this->getEntityManager()->createQuery('SElECT s.id from ShopBundle:Shops s WHERE s.id=:id AND s.interfacePassword=:pw')
            ->setParameter('id', $shopId)
            ->setParameter('pw', $password)
            ->getResult();
    }

    public function getByShop(int $shopId, string $password, $firstElement, $items)
    {
        $id = $this->getShop($shopId, $password);

        return $this->getEntityManager()->createQuery(
            'SELECT r.review FROM ShopBundle:ShopReviews r WHERE r.fkShop=:shopId'
        )->setParameter('shopId', $id)
            ->setFirstResult($firstElement-1)
            ->setMaxResults($items)
            ->getResult();
    }

    public function getByCreationAndUpdateDate($shopId, $password, $firstElement, $items, $creation, $creationTo, $update, $updateTo)
    {
        $id = $this->getShop($shopId, $password);

        return $this->getEntityManager()->createQuery(
            'SELECT r.review FROM ShopBundle:ShopReviews r WHERE r.fkShop=:shopId AND r.createdAt BETWEEN :createdat AND :createdto  AND r.updatedAt BETWEEN :updatedat AND :updatedto  '
        )->setParameter('shopId', $id)
            ->setParameter('createdat', $creation)
            ->setParameter('createdto', $creationTo)
            ->setParameter('updatedto', $update)
            ->setParameter('updatedat', $updateTo)
            ->setFirstResult($firstElement-1)
            ->setMaxResults($items)
            ->getResult();
    }

    public function getByCreationBetween($shopId, $password, $firstElement, $items, $creation, $creationTo)
    {
        $id = $this->getShop($shopId, $password);

        return $this->getEntityManager()->createQuery(
            'SELECT r.review FROM ShopBundle:ShopReviews r WHERE r.fkShop=:shopId AND r.createdAt BETWEEN :createdat AND :createdto '
        )->setParameter('shopId', $id)
            ->setParameter('createdat', $creation)
            ->setParameter('createdto', $creationTo)
            ->setFirstResult($firstElement-1)
            ->setMaxResults($items)
            ->getResult();
    }

    public function getByUpdateBetween($shopId, $password, $firstElement, $items, $update, $updateTo)
    {
        $id = $this->getShop($shopId, $password);

        return $this->getEntityManager()->createQuery(
            'SELECT r.review FROM ShopBundle:ShopReviews r WHERE r.fkShop=:shopId AND r.updatedAt BETWEEN :updatedat AND :updatedto '
        )->setParameter('shopId', $id)
            ->setParameter('updatedat', $update)
            ->setParameter('updatedto', $updateTo)
            ->setFirstResult($firstElement-1)
            ->setMaxResults($items)
            ->getResult();
    }

}
