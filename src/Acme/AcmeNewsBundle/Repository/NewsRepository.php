<?php

namespace Acme\AcmeNewsBundle\Repository;

use Acme\AcmeNewsBundle\Entity\News;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function baseQuery()
    {
        return $this->createQueryBuilder('n')
            ->where('n.published = 1');
    }


    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNewsQB()
    {
        return $this->baseQuery()->orderBy('n.createdAt', 'DESC');
    }


    /**
     * Get array of ids of news
     *
     * @return array
     */
    public function getIdsOfNews(News $except = null, $from = null, $to = null)
    {
        $qb = $this->baseQuery()
            ->select('n.id');

        if (!empty($except)) {
            $qb->andWhere('n <> :except')
                ->setParameter('except', $except);
        }

        return $qb->getQuery()->getArrayResult();
    }


    /**
     * @return News|null
     */
    public function getNewsById($id)
    {
        return $this->baseQuery()
            ->andWhere('n.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @return array
     */
    public function getNewsByIds(array $ids)
    {
        return $this->baseQuery()
            ->andWhere('n.id in (:ids)')
            ->setParameter('ids', $ids)
            ->getQuery()
            ->getResult();
    }
}