<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Form\VoitureType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
                'success',
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

        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

        return $this->render('/voitures/listevoitures.html.twig', ['voitures' => $voitures]);
    }

    /**
     * @Route("/listevoitures/categorie", name="liste_voitures_categorie")
     */
    public function listeVoituresParCategorie() {

        $voitures = $this->getDoctrine()->getRepository(Voiture::class)->findAll();

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
     * @Route("/voitures/{marque}", name="voitures_marque")
     */
    public function voituresParMarque(Voiture $voiture){

        $marque = $this->getMarque();

        $voitures = $this->getDoctrine()
        ->getRepository(Voiture::class)
        ->findAllParMarque($marque);

    }



}
