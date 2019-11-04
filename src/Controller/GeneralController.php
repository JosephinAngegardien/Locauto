<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Marque;
use App\Form\AgenceType;
use App\Form\MarqueType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GeneralController extends AbstractController
{
    /**
     * @Route("/", name="accueil")
     */
    public function accueil()
    {
        return $this->render('accueil.html.twig');
    }

    // /**
    //  * @Route("/deuxieme", name="deuxieme")
    //  */
    // public function deuxiemePage()
    // {
    //     return $this->render('pages/deuxieme.html.twig');
    // }

    /**
     * @Route("/enregistreragence", name="enregistrer_agence")
     */
    public function enregistrerAgence(Request $request, ObjectManager $manager)
    {
        $agence = new Agence();
        $form = $this->createForm(AgenceType::class, $agence);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($agence);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'agence de {$agence->getVille()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('accueil');
        }

        return $this->render('/pages/enregistreragence.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/enregistrermarque", name="enregistrer_marque")
     */
    public function enregistrerMarque(Request $request, ObjectManager $manager)
    {
        $marque = new Marque();
        $form = $this->createForm(MarqueType::class, $marque);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($marque);
            $manager->flush();

            $this->addFlash(
                'success',
                "La marque {$marque->getNom()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('accueil');
        }

        return $this->render('/pages/enregistrermarque.html.twig', [
            'form' => $form->createView()
        ]);
    }



}


