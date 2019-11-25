<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureSearchType;
use App\Form\VoitureType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Response as SymfonyResponse;
use App\Entity\VoitureSearch;

class VoitureController extends AbstractController
{

    /**
     * @Route("/enregistrervoiture", name="enregistrer_voiture")
     * @IsGranted("ROLE_ADMIN")
     */
    public function enregistrerVoiture(Request $request, ObjectManager $manager)
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($voiture);
            $manager->flush();

            $this->addFlash(
                'message flash',
                "Le modèle {$voiture->getModele()} a bien été enregistré !"
            );

            return $this->redirectToRoute('liste_voitures');
        }

        return $this->render('/voitures/enregistrervoiture.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/voirvoiture/{slug}", name="voir_voiture")
     * 
     * @return Response
     */
    public function show(Voiture $voiture){
        return $this->render('voitures/voirvoiture.html.twig', [
            'voiture' => $voiture
        ]);
    }

    /**
     * @Route("/listevoitures", name="liste_voitures")
     */
    public function listeVoitures() {

        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->voituresMarquesClassees();
        return $this->render('/voitures/listevoitures.html.twig', ['voitures' => $voitures]);
    }

    /**
     * @Route("/supprimervoiture/{slug}", name="supprimer_voiture")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprVoiture(Voiture $voiture, ObjectManager $manager) {

        $manager->remove($voiture);
        $manager->flush();
  
        return $this->redirectToRoute('liste_voitures');
    }

    /**
     * @Route("/modifvoiture/{slug}", name="modif_voiture")
     * @IsGranted("ROLE_ADMIN")
     */
    public function modifierVoiture(Voiture $voiture, Request $request, ObjectManager $manager){
        
        $form=$this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($voiture);
            $manager->flush();

            return $this->redirectToRoute('voir_voiture', ['slug' => $voiture->getSlug()]);
        }

        return $this->render('voitures/enregistrervoiture.html.twig', ['form' => $form->createView(), 'voiture' => $voiture]);
    }

    /**
     * @Route("/voitures", name="recherche_voitures")
     * 
     * @return Response
     */
    public function rechercheVoitures(Request $request){

        $voitures = null;
        $search = new VoitureSearch;
        $form = $this->createForm(VoitureSearchType::class, $search);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();

        if($form->isSubmitted() && $form->isValid()){
               
            $voitures = $em->getRepository(Voiture::class)->findVoituresBySearch($search);

        }

        return $this->render('/voitures/listevoitures.html.twig', [
            'form' => $form->createView(),
            'voitures' => $voitures,
        ]);

    }



}
