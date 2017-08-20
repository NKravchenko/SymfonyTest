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
     * Получить все новости
     *
     * @return News[]
     */
    public function getNews()
    {
        return $this->newsRepository->getNews()->getQuery()->getResult();
    }

    /**
     * Получить новости в соответствии с номером страницы
     *
     * @param int|null $page
     * @param int|null $maxresult
     *
     * @return AbstractPagination
     */
    public function getNewsByPage(int $page = null, int $maxresult = null)
    {
        /** @var \Doctrine\ORM\QueryBuilder $newsQB */
        $newsQB = $this->newsRepository->getNews();

        /** @var AbstractPagination $fromPaginator */
        $fromPaginator = $this->paginator->paginate(
            $newsQB, /* query NOT result */
            $page,
            $maxresult
        );

        return $fromPaginator;
    }

    /**
     * Массив случайных новостей
     *
     * @param int|null $maxresult
     *
     * @return News[]
     */
    public function getRandomNews(int $maxresult = null, News $exeptNews)
    {
        return $this->newsRepository->getRandomNews($maxresult, $exeptNews);
    }

}