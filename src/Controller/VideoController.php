<?php

namespace App\Controller;

use App\Helpers\Constants;
use App\Helpers\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("/download/{videoId}/{videoTitle}", name="songDownload")
     * @param string $videoId
     * @param string $videoTitle
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(string $videoId, string $videoTitle)
    {
        //$url = "https://hints4u.net/download/".$videoId.".html";
        //return $this->redirect($url, 301);

        try {
            $video = null;
            if(Constants::$loadMoreVideoData)
                $video = json_decode(file_get_contents(
                        Utils::generateVideoFullUrl(
                            Constants::$lightVideoResult,
                            Constants::$showRelatedVideos
                            )
                        .urlencode($videoId))
                );
            if($video != null and !empty($video)){
                $empty=false;
                return $this->render('video/index.html.twig', [
                    'video' => $video,
                    'videoId' => $videoId,
                    'slug' => $videoTitle,
                    'videoTitle' => Utils::slugToText($videoTitle),
                    'empty' => $empty,
                    'loadMoreVideoData' => Constants::$loadMoreVideoData,
                    'site_config' => Constants::$siteConfig
                ]);
            }else{
                $empty = true;
                return $this->render('video/index.html.twig', [
                    'videoId' => $videoId,
                    'slug' => $videoTitle,
                    'videoTitle' => Utils::slugToText($videoTitle),
                    'description' => "",
                    'empty' => $empty,
                    'loadMoreVideoData' => Constants::$loadMoreVideoData,
                    'site_config' => Constants::$siteConfig
                ]);
            }
        }catch (\Exception $e) {
            $empty = true;
            return $this->render('video/index.html.twig', [
                'videoId' => $videoId,
                'videoTitle' => Utils::slugToText($videoTitle),
                'empty' => $empty,
                'loadMoreVideoData' => Constants::$loadMoreVideoData,
                'site_config' => Constants::$siteConfig
            ]);

        }

    }
}
