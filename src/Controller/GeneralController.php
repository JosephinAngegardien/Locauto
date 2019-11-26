<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Agence;
use App\Entity\Marque;
use App\Form\ImageType;
use App\Form\AgenceType;
use App\Form\MarqueType;
use App\Entity\Categorie;
use App\Form\CategorieFormType;
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
                'Avertissement',
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

        $agences = $this->getDoctrine()->getRepository(Agence::class)->findBy([], ["ville"=>"ASC"]);

        return $this->render('/pages/listeagences.html.twig', ['agences' => $agences]);
    }

    /**
     * @Route("/supprimeragence/{id}", name="supprimer_agence")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprAgence(Agence $agence, ObjectManager $manager) {

        if(count($agence->getVoitures()) ==0 ){

        $manager->remove($agence);
        $manager->flush();
  
        return $this->redirectToRoute('liste_agences');
        }
        else{
            $this->addFlash("Avertissement", "Cette agence possède une ou plusieurs voitures.");
            return $this->redirectToRoute('liste_agences');
        }
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
                'Avertissement',
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

        $marques = $this->getDoctrine()->getRepository(Marque::class)->findBy([], ["nom"=>"ASC"]);

        return $this->render('/pages/listemarques.html.twig', ['marques' => $marques]);
    }

    /**
     * @Route("/supprimermarque/{slug}", name="supprimer_marque")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprMarque(Marque $marque, ObjectManager $manager) {

        if(count($marque->getVoitures()) == 0){

            $manager->remove($marque);
            $manager->flush();
    
            return $this->redirectToRoute('liste_marques');
        }
        else{
            $this->addFlash("Avertissement", "Il y a des véhicules de cette marque en base de données.");
            return $this->redirectToRoute('liste_marques'); 
        }

    }

    /**
     * @Route("/enregistrerimage", name="enregistrer_image")
     * @IsGranted("ROLE_ADMIN")
     */
    public function enregistrerImage(Request $request, ObjectManager $manager)
    {
        $image = new Image();
        $form = $this->createForm(ImageType::class, $image);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($image);
            $manager->flush();

            // $this->addFlash(
            //     'success',
            //     "L'agence de {$agence->getVille()} a bien été enregistrée !"
            // );

            return $this->redirectToRoute('liste_images');
        }

        return $this->render('/pages/enregistrerimage.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listeimages", name="liste_images")
     * @IsGranted("ROLE_ADMIN")
     */
    public function listeImages() {

        $images = $this->getDoctrine()->getRepository(Image::class)->findAll();

        return $this->render('/pages/listeimages.html.twig', ['images' => $images]);
    }

    /**
     * @Route("/supprimerimage/{id}", name="supprimer_image")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprImage(Image $image, ObjectManager $manager) {

        if(is_null($image->getVoiture())){

        $manager->remove($image);
        $manager->flush();
  
        return $this->redirectToRoute('liste_images');

        }

        else{
            return $this->redirectToRoute('liste_images');
            $this->addFlash("message flash", "Cette image est liée à une voiture.");
        }
    }

    /**
     * @Route("/enregistrercategorie", name="enregistrer_categorie")
     * @IsGranted("ROLE_ADMIN")
     */
    public function enregistrerCategorie(Request $request, ObjectManager $manager)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieFormType::class, $categorie);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($categorie);
            $manager->flush();

            $this->addFlash(
                'Avertissement',
                "L'agence de {$categorie->getNom()} a bien été enregistrée !"
            );

            return $this->redirectToRoute('liste_categories');
        }

        return $this->render('/pages/enregistrercategorie.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/listecategories", name="liste_categories")
     */
    public function listeCategories() {

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('/pages/listecategories.html.twig', ['categories' => $categories]);
    }

    /**
     * @Route("/supprimercategorie/{id}", name="supprimer_categorie")
     * @IsGranted("ROLE_ADMIN")
     */
    public function supprCategorie(Categorie $categorie, ObjectManager $manager) {

        $manager->remove($categorie);
        $manager->flush();
  
        return $this->redirectToRoute('liste_categories');
    }


}


