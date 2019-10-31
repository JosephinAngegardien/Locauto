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
    // /**
    //  * @Route("/robots/liste", name="liste_robots")
    //  */
    // public function listeRobots()
    // {
    //     return $this->render('robots/liste.html.twig', [
    //         'controller_name' => 'RobotsController',
    //     ]);
    // }

    // /**
    //  * @Route("/admin/listerobots", name="admin_liste_robots")
    //  */
    // public function adminListeRobots()
    // {
    //     return $this->render('admin/listerobots.html.twig', [
    //         'controller_name' => 'RobotsController',
    //     ]);
    // }

    /**
     * @Route("/enregistrervoiture", name="enregistrer_voiture")
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

            return $this->redirectToRoute('voirvoiture');
        }

        return $this->render('/voitures/enregistrervoiture.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/voirvoiture", name="voir_voiture")
     * 
     * @return Response
     */
    public function show(Voiture $voiture){
        return $this->render('voitures/voirvoiture.html.twig', [
            'robot' => $robot
        ]);
    }

}
