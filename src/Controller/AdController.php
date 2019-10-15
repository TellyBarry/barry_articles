<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('index.html.twig', [
            'controller_name' => 'AdController',
        ]);
    }

    /**
     * @Route("/ads", name="ads_index")
     */
    public function ads(ArticleRepository $repo)
    {
        $ads = $repo->findAll();
        return $this->render('ad/index.html.twig', [
            'ads' => $ads,
        ]);
    }

       /**
     * Permet d'afficher une seule annonce
     *
     * @Route("/ads/{id}", name="ads_show")
     * 
     * @return Response
     */
    public function show(Article $ad){
        return $this->render('ad/show.html.twig',[
        'ad' => $ad]);
    }
}
