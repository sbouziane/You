<?php

namespace App\Controller;

use App\Helpers\Constants;
use App\Helpers\Utils;
use App\Repository\SearchRepository;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SiteMapController extends AbstractController
{
    /**
     * @var SearchRepository
     */
    private $searchRepository;

    public function __construct(SearchRepository $searchRepository)
    {
        $this->searchRepository = $searchRepository;
    }

    /**
     * @Route("/sitemap-index", name="sitemap-index")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $hostname = $request->getSchemeAndHttpHost();
        try {
            $countNewRows = $this->searchRepository
                ->getNumberOfRowsForNewSiteMap(Constants::$newSiteMapStartRow, Constants::$stopSiteMapAt);
            $nbOfSiteMaps = ceil($countNewRows/Constants::$maxLinesBySiteMap);
            $response = new Response(
                $this->renderView('sitemap/index.html.twig', array(
                    'nbOfSiteMaps' => $nbOfSiteMaps,
                    'hostname' => $hostname)),
                200
            );
            $response->headers->set('Content-Type', 'text/xml');

            return $response;
        } catch (NoResultException $e) {
            return $this->redirectToRoute('404-page');
        }

    }

    /**
     * @Route("/sitemap-index/{page}", name="new-sitemap-page")
     * @param Request $request
     * @param int $page
     * @return Response
     */
    public function page(Request $request, int $page)
    {
        $hostname = $request->getSchemeAndHttpHost();
        $start = ($page-1) * Constants::$maxLinesBySiteMap + Constants::$newSiteMapStartRow;
        $limit = $page * Constants::$maxLinesBySiteMap + Constants::$newSiteMapStartRow;
        $searches = $this->searchRepository->getSearchSiteMap($start, $limit);
        $urls = array();
        foreach ($searches as $search) {
            $query = $search->getSearchText();
            if ($query!= null and !empty($query) and $query != ""){
                $query = Utils::cleanSearchAndMakeSlug($query);
                $urls[] = array(
                    'loc' => $this->generateUrl('search_page',
                        array(
                            'query' => $query
                        )
                    )
                );
            }
        }
        $response = new Response(
            $this->renderView('sitemap/page.html.twig', array(
                'urls' => $urls,
                'hostname' => $hostname)),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;
    }
}
