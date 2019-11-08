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
     * @Route("/voirvoiture/{id}", name="voir_voiture")
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
     * @Route("/supprimervoiture/{id}", name="supprimer_voiture")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprVoiture(Voiture $voiture, ObjectManager $manager) {

        $manager->remove($voiture);
        $manager->flush();
  
        return $this->redirectToRoute('liste_voitures');
    }

    /**
     * @Route("/modifvoiture/{id}", name="modif_voiture")
     */
    public function modifierVoiture(Voiture $voiture, Request $request, ObjectManager $manager){
        
        $form=$this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($voiture);
            $manager->flush();

            return $this->redirectToRoute('voir_voiture', ['id' => $voiture->getID()]);
        }

        return $this->render('voitures/enregistrervoiture.html.twig', ['form' => $form->createView(), 'voiture' => $voiture]);
    }



}
