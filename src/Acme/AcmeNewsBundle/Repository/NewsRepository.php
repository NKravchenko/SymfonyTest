<?php
/**
 * Created by PhpStorm.
 * User: jimm
 * Date: 16.08.17
 * Time: 18:22
 */

namespace Acme\AcmeNewsBundle\Repository;

use Acme\AcmeNewsBundle\Entity\News;
use Doctrine\ORM\EntityRepository;

class NewsRepository extends EntityRepository
{

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNews()
    {
        return $this->createQueryBuilder('n')
            ->where('n.published = 1');
    }

    /**
     * @param int $maxResult
     * @param News|null $except
     *
     * @return array
     */
    public function getRandomNews(int $maxResult = 1, News $except = null)
    {
        $qb = $this->createQueryBuilder('n')
            ->addSelect('RAND() as HIDDEN rand')
            ->where('n.published = 1')
            ->setMaxResults($maxResult)
            ->addOrderBy('rand');

        if (!empty($except)) {
            $qb->andWhere('n <> :except')
                ->setParameter('except', $except);
        }

        return $qb->getQuery()->getResult();
    }

}