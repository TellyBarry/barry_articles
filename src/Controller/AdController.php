<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\AdminType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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



       /**
     * Permet d'afficher le formulaire d'edition
     * 
     * 
     * @Route("/ads/{id}/edit", name="ads_edit" )
     * @return Response
     */
    public function edit(Article $ad, Request $request){
        $form = $this->createForm(AdminType::class, $ad);
        $form->handleRequest($request);
        return $this->render('ad/edit.html.twig',[
            'form'=> $form->createView(),
            'ad'=>$ad
        ]);
    }
    

    /**
     * Tableau liste articles
     * 
     * @Route("/admin", name="articles_admin")
     * 
     */
    public function TableauAdmin(ArticleRepository $repo)
    {
        $ads = $repo->findAll();
        return $this->render('ad/admin.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Suprimer 
     * 
     * 
     */
    

     /**
     * Creer une annonce
     *
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager){
        $ad = new Article();
    
        $form = $this->createForm(AdminType::class, $ad);

        $form->handleRequest($request);
    
        
        if($form->isSubmitted()&& $form->isValid()){
            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();
            
            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été enregistrée !"
            );
            
            return $this->redirectToRoute('ads_show', [
                'slug' => $ad -> getSlug()
                ]);
            }

        return $this->render('ad/new.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
