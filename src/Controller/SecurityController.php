<?php

namespace App\Controller;

use App\Entity\Particulier;
use App\Entity\Professionnel;
use App\Form\ParticulierType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
// use App\Form\ProfileType;

class SecurityController extends AbstractController
{
    /**
     * @Route("/loginpart", name="login_part")
     */
    public function loginPart(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginpart.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }

    /**
     * @Route("/registerpart", name="register_part")
     */
    public function registerPart(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Particulier();
        $form = $this->createForm(ParticulierType::class, $user);      //On relie les champs du formulaire aux champs de l'utilisateur.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute("login_part");

        }

        return $this->render('security/registerpart.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/loginpro", name="login_pro")
     */
    public function loginPro(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginpro.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/registerpro", name="register_pro")
     */
    public function registerPro(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new Professionnel();
        $form = $this->createForm(ProfessionnelType::class, $user);      //On relie les champs du formulaire aux champs de l'utilisateur.
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->redirectToRoute("login_pro");

        }

        return $this->render('security/registerpro.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }


}


