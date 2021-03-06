<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Data\SearchData;
use App\Entity\Location;
use App\Form\SearchForm;
use App\Form\VoitureType;
use App\Entity\Commentaire;
use App\Entity\VoitureSearch;
use App\Form\CommentaireType;
use App\Form\VoitureSearchType;
use App\Repository\VoitureRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\BrowserKit\Response as SymfonyResponse;
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
                'Avertissement',
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
    public function show(Voiture $voiture, Request $request, ObjectManager $manager){

        if($this->getUser()){
            $newComment = new Commentaire();
            $newComment->setVoiture($voiture);
            $newComment->setAuteur($this->getUser());   // L'utilisateur connecté peut donner son avis sur le véhicule, qu'il l'ai loué ou non (problème).
            $form = $this->createForm(CommentaireType::class, $newComment);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid()){

                $manager->persist($newComment);
                $manager->flush();
    
                $this->addFlash(
                    'Avertissement',
                    "Votre commentaire a été enregistré !"
                );
    
                return $this->redirectToRoute('voir_voiture', ['slug' => $voiture->getSlug()]);
            }
            $form = $form->createView();    // Si aucun formulaire n'a encore été validé, on en crée un.
        }
        else $form = null;      // Pas d'utilisateur ? Pas de formulaire.

        return $this->render('voitures/voirvoiture.html.twig', [
            'voiture' => $voiture,
            'form' => $form
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

        if(is_null($voiture->getImages()) )
        {
        $manager->remove($voiture);
        $manager->flush();
  
        return $this->redirectToRoute('liste_voitures');
        }
        $this->addFlash(
            'Avertissement',
            "La fiche de ce véhicule ne peut être supprimée.");
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

            if(empty($voitures)){

                $this->addFlash(
                    'Avertissement',
                    "Aucun véhicule ne correspond à vos critères de recherche.");
            }

        }

        return $this->render('/voitures/listevoitures.html.twig', [
            'form' => $form->createView(),
            'voitures' => $voitures,
        ]);

    }

    /**
     * @Route("/voitures2", name="recherche_voitures2")
     */
    public function index(VoitureRepository $repository, Request $request)
    {

        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $voitures = $repository->findSearch($data);

        return $this->render('/voitures/listevoitures2.html.twig', [
            'voitures' => $voitures,
            'form' => $form->createView()
        ]);

    }



}
