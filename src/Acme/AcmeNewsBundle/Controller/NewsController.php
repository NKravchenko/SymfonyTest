<?php
/**
 * Created by PhpStorm.
 * User: jimm
 * Date: 16.08.17
 * Time: 14:41
 */

namespace Acme\AcmeNewsBundle\Controller;

use Acme\AcmeNewsBundle\Entity\News;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class NewsController
 *
 * @package Acme\AcmeNewsBundle\Controller\Web
 */
class NewsController extends Controller
{

    const MAXNEWSDEF = 5; //число отображаемых новостей на странице

    /**
     * Получить новости в зависимости от страницы и формата
     * @Route(
     *     "/news.{_format}",
     *     name="get_news",
     *     defaults={"_format": "html"},
     *     requirements={"_format": "xml"}
     *  )
     * @Method("GET")
     *
     * @param Request $request
     * @param $_format
     *
     * @return Response
     */
    public function getNewsAction(Request $request, $_format)
    {
        $page = $request->query->getInt('page', 1);

        $fromPaginator = $this->get('acme_news.service.news')->getNewsByPage($page, $this::MAXNEWSDEF);

        if ($_format === 'xml') {
            $response = $this->render('@AcmeNews/news/news.xml.twig', ['news' => $fromPaginator->getItems()]);
            $response->headers->set('Content-Type', 'application/xml; charset=utf-8');

            return $response;
        } else {
            return $this->render('@AcmeNews/news/news.html.twig', ['news' => $fromPaginator]);
        }
    }

    /**
     * Подробное отображение новости по ее id
     * плюс отображение нескольких случайных новостей
     * @Route("/news/{newsId}", name="get_news_by_id")
     * @ParamConverter("newsItem", options={"mapping" :{"newsId" : "id"}})
     */
    public function getNewsByIdAction(News $newsItem)
    {
        //массив случайных новостей
        /** @var News[] $rndNews */
        $rndNews = $news = $this->get('acme_news.service.news')->getRandomNews(5, $newsItem);

        return $this->render(
            '@AcmeNews/news/news_item.html.twig',
            [
                'item' => $newsItem,
                'news' => $rndNews,
            ]
        );
    }


}