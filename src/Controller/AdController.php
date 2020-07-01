<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * Displays all ads / Affiche toutes les annonces
     * 
     * @Route("/ads", name="ads_index")
     * 
     */
    public function index(AdRepository $repo)
    {
        $ads = $repo->findAll();

        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

   /**
    * 
    * Displays a single ad / Permet d'afficher une seule annonce
    *
    *@Route("/ads/{slug}", name="ads_show" )
    *
    * @return Response
    */
    public function show($slug, AdRepository $repo)
    {
        //Get the ad that matches the slug / Récupère l'annonce qui correspond au slug
        $ad = $repo->findOneBySlug($slug);

        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
