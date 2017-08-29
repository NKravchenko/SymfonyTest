<?php

namespace Acme\AcmeNewsBundle\Services;

use Acme\AcmeNewsBundle\Entity\News;
use Acme\AcmeNewsBundle\Repository\NewsRepository;
use Knp\Component\Pager\Pagination\AbstractPagination;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\Paginator;

class NewsService
{
    /** @var NewsRepository */
    private $newsRepository;
    /** @var Paginator */
    private $paginator;

    public function __construct(NewsRepository $newsRepository, Paginator $paginator)
    {
        $this->newsRepository = $newsRepository;
        $this->paginator      = $paginator;
    }

    /**
     *  Get all published news
     *
     * @return News[]
     */
    public function getNews()
    {
        return $this->newsRepository->getNewsQB()->getQuery()->getResult();
    }

    /**
     * Get published news by page
     *
     * @param int|null $page
     * @param int|null $maxresult
     *
     * @return AbstractPagination
     */
    public function getNewsByPage(int $page = null, int $maxresult = null)
    {
        /** @var \Doctrine\ORM\QueryBuilder $newsQB */
        $newsQB = $this->newsRepository->getNewsQB();

        /** @var AbstractPagination $fromPaginator */
        $fromPaginator = $this->paginator->paginate(
            $newsQB,
            $page,
            $maxresult
        );

        return $fromPaginator;
    }

    /**
     * Get array of random news
     *
     * @param int|null $maxresult
     *
     * @return News[]
     */
    public function getRandomNews(int $maxresult = 5, News $exceptNews)
    {
        /* Algorithm:
         * - get the array of id of actual news (like [1, 2, 5])
         * - shuffle it
         * - determine a offset
         * - do a slice by offset
         * - get News[] by array of random id
         */

        $newsIds = $this->getIdsOfNews($exceptNews);
        shuffle($newsIds);
        $offset     = $this->getRndOffset(count($newsIds), $maxresult);
        $rndNewsIds = array_slice($newsIds, $offset, $maxresult);

        return $this->newsRepository->getNewsByIds($rndNewsIds);
    }

    /**
     * Create array of ids of all published news
     *
     * @param News $exceptNews
     *
     * @return array
     */
    private function getIdsOfNews(News $exceptNews)
    {
        $initialNewsIds = $this->newsRepository->getIdsOfNews($exceptNews);
        $newsIds        = [];
        foreach ($initialNewsIds as $item) {
            $newsIds[] = $item['id'];
        }

        return $newsIds;
    }

    /**
     * Generate a random offset value for a next slice function
     *
     * @param int $length
     * @param int $maxresult
     *
     * @return int
     */
    private function getRndOffset(int $length, int $maxresult)
    {

        if ($maxresult >= $length) {
            return 0;
        }

        $offset = mt_rand(0, ($length - $maxresult));

        return $offset;
    }

}