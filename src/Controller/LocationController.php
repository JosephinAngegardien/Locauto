<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Voiture;
use App\Entity\Location;
use App\Form\LocationType;
use App\Entity\Commentaire;
use App\Form\CommentaireType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LocationController extends AbstractController
{
    /**
     * @Route("/location/{slug}", name="louer_voiture")
     * @IsGranted("ROLE_USER")
     */
    public function location(Voiture $voiture, Request $request, ObjectManager $manager)
    {
        $loc = new Location();
        $form = $this->createForm(LocationType::class, $loc);

        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();

            $loc->setUser($user)
                    ->setVoiture($voiture);

            /*$loc->setMontant(et tu refais la multiplication que te fait javascript)*/
            $interval = date_diff($loc->getDebut(), $loc->getFin() );
            $nbjours = intval($interval->format('%R%a days') );
            $loc->setMontant($voiture->getTarif() * ($nbjours) );

            // Si les dates ne sont pas disponibles, message d'erreur
            if(!$loc->isBookableDates()) {
                $this->addFlash(
                    'warning',
                    "Les dates que vous avez choisies ne peuvent être réservées : elles sont déjà prises."
                );
            } else {
                // Sinon enregistrement et redirection
                $manager->persist($loc);
                $manager->flush();
    
                return $this->redirectToRoute('voir_reservation', ['id' => $loc->getId(), 'withAlert' => true]);
            }
        }

        return $this->render('pages/reservation.html.twig', [
            'voiture' => $voiture,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'afficher la page d'une réservation
     *
     * @Route("/reservation/{id}", name="voir_reservation")
     * 
     * @param Location $location
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function show(Location $loc, Request $request, ObjectManager $manager) {

        $comment = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $comment->setAd($loc->getAd())
                    ->setAuthor($this->getUser());

            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre commentaire a bien été pris en compte !"
            );
        }

        return $this->render('pages/voirreservation.html.twig', [
            'location' => $loc,
            'form'    => $form->createView()
        ]);
    }

    /**
     * @Route("/particulier", name="locations_part")
     */
    public function pageParticulier()
    {
        return $this->render('pages/locpart.html.twig');
    }


}

