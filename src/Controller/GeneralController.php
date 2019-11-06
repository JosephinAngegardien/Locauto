<?php

namespace App\Controller;

use App\Entity\Agence;
use App\Entity\Marque;
use App\Form\AgenceType;
use App\Form\MarqueType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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

    /**
     * @Route("/enregistreragence", name="enregistrer_agence")
     * @IsGranted("ROLE_ADMIN")
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

            return $this->redirectToRoute('liste_agences');
        }

        return $this->render('/pages/enregistreragence.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listeagences", name="liste_agences")
     */
    public function listeAgences() {

        $agences = $this->getDoctrine()->getRepository(Agence::class)->findAll();

        return $this->render('/pages/listeagences.html.twig', ['agences' => $agences]);
    }

    /**
     * @Route("/supprimeragence/{id}", name="supprimer_agence")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprAgence(Agence $agence, ObjectManager $manager) {

        $manager->remove($agence);
        $manager->flush();
  
        return $this->redirectToRoute('liste_agences');
    }

    /**
     * @Route("/enregistrermarque", name="enregistrer_marque")
     * @IsGranted("ROLE_ADMIN")
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

            return $this->redirectToRoute('liste_marques');
        }

        return $this->render('/pages/enregistrermarque.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listemarques", name="liste_marques")
     */
    public function listeMarques() {

        $marques = $this->getDoctrine()->getRepository(Marque::class)->findAll();

        return $this->render('/pages/listemarques.html.twig', ['marques' => $marques]);
    }

    /**
     * @Route("/supprimermarque/{id}", name="supprimer_marque")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprMarque(Marque $marque, ObjectManager $manager) {

        $manager->remove($marque);
        $manager->flush();
  
        return $this->redirectToRoute('liste_marques');
    }



}


