<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Image;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * Create an ad / Permet de créer une annonce
     * 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Response
     * 
     */
    public function create(Request $request, EntityManagerInterface $manager)
    {
        $ad = new Ad();

        $form = $this->createForm(AdType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a été bien enregistrée.'
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('ad/create.html.twig', [
            'formAd' => $form->createView()
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
    public function show(Ad $ad)
    {
        //Get the ad that matches the slug / Récupère l'annonce qui correspond au slug
        return $this->render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
