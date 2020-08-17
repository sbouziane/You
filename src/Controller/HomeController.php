<?php

namespace App\Controller;

use App\Helpers\Constants;
use App\Repository\SearchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
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
     * @Route("/", name="home")
     */
    public function index()
    {
        $searches = $this->searchRepository->getSearchesByLatest(41)->getResult();
        return $this->render('home/index.html.twig', [
            'searches' => $searches,
            'site_config' => Constants::$siteConfig
        ]);
    }

}
