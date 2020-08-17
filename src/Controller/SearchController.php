<?php

namespace App\Controller;

use App\Entity\Search;
use App\Form\SearchType;
use App\Helpers\Constants;
use App\Helpers\Utils;
use App\Repository\SearchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class SearchController extends AbstractController
{
    /**
     * @var FormFactoryInterface
     */
    private $formFactory;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var SearchRepository
     */
    private $searchRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;


    public function __construct(
        FormFactoryInterface $formFactory,
        RouterInterface $router,
        SearchRepository $searchRepository,
        EntityManagerInterface $entityManager){
        $this->formFactory = $formFactory;
        $this->router = $router;
        $this->searchRepository = $searchRepository;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/song/{query}/", name="search_page")
     * @param string $query
     * @return Response
     */
    public function index(string $query)
    {
        $clean_query = Utils::slugToText($query);
        if(empty($clean_query) || Utils::is_bad_word($clean_query))
            return $this->redirectToRoute('404-page');

        try {
            if(Utils::isArabic($clean_query)) {
                $search = $this->searchRepository->getSearch($clean_query);
                if ($search != null) {
                    $search->setSearchTimes($search->getSearchTimes() + 1);
                    $this->entityManager->persist($search);
                } else {
                    $search = new Search();
                    $search->setSearchTimes(1);
                    $search->setSearchText($clean_query);
                    $this->entityManager->persist($search);
                }
                $this->entityManager->flush();
            }

            $videos = json_decode(file_get_contents(
                    Utils::generateSearchFullUrl(Constants::$lightSearchResult)
                    .urlencode($query))
            );
            if (empty($videos))
                return $this->redirectToRoute('404-page');

            return $this->render('search/index.html.twig',
                [
                    'videos' => $videos,
                    'searchText' => $clean_query,
                    'site_config' => Constants::$siteConfig
                ]
            );

        }catch (\Exception $e) {
            return $this->redirectToRoute('404-page');
        }

    }


    /**
     * @Route("/search-action", name="searchAction")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function searchAction(Request $request){
        $search = new Search();
        $form = $this->formFactory->create(SearchType::class, $search);
        $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){
                if($search->getSearchText() !=null  and !empty($search->getSearchText()))
                    return
                        $this->redirectToRoute('search_page',
                            [
                                'query' => Utils::cleanSearchAndMakeSlug($search->getSearchText())
                            ])
                        ;
                else
                    return $this->redirectToRoute('404-page');
            }
        return $this->render('search/form.html.twig', [
            'form' => $form->createView(),
            'site_config' => Constants::$siteConfig
        ]);
    }
}
