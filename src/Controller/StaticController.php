<?php

namespace App\Controller;

use App\Helpers\Constants;
use App\Repository\SearchRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class StaticController extends AbstractController
{
    /**
     * @var SearchRepository
     */
    private $searchRepository;
    /**
     * @var PaginatorInterface
     */
    private $paginator;



    public function __construct(
        SearchRepository $searchRepository,
        PaginatorInterface $paginator
    )
    {

        $this->searchRepository = $searchRepository;
        $this->paginator = $paginator;
    }

    /**
     * @Route("/top-------searches/", name="topSearches")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function topSearches(Request $request)
    {
        $mostSearchableQB = $this->searchRepository->getSearchesBySearchTimes(500);
        $pagination = $this->paginator->paginate(
            $mostSearchableQB, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            Constants::$paginatorSize/*limit per page*/
        );

        return $this->render('static/top-search.html.twig',
            [
                'pagination' => $pagination,
                'site_config' => Constants::$siteConfig
            ]);
    }
    /**
     * @Route("/new-searches/", name="newSearches")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newSearches(Request $request)
    {
        $page = $request->query->get('page', 1);
        $newSearchable = $this->searchRepository->getSearchesByLatest(500);
        $pagination = $this->paginator->paginate(
            $newSearchable, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            Constants::$paginatorSize/*limit per page*/
        );

        return $this->render('static/new-search.html.twig',
            [
                'pagination' => $pagination,
                'site_config' => Constants::$siteConfig
            ]);
    }
    /**
     * @Route("/404/", name="404-page")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function notfound(){
        return $this->render('static/404.html.twig',[
            'site_config' => Constants::$siteConfig
        ]);
    }

    /**
     * @Route("/error/", name="error-page")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showErr(){
        return $this->render('static/error.html.twig',[
            'site_config' => Constants::$siteConfig
        ]);
    }
}
