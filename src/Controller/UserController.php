<?php

namespace App\Controller;

use App\Entity\Pays;
use App\Entity\Abonne;
use App\Repository\AbonneRepository;
use phpDocumentor\Reflection\Types\Null_;
use Symfony\Component\Form\Forms;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Form\FormTypeInterface;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     *  @Route("/panier", name="user_panier")
     *  @Route("/{codeAbonne}/panier", name="user_panier1")
     */
    public function panier(Abonne $abonne = null,AbonneRepository $abonneRepo)
{
    if (!$abonne) {
        return $this->render('user/panier.html.twig', [
            'controller_name' => 'UserController',

        ]);
    } else {
        $achats = $abonneRepo->achatsNonConfirmes($abonne);
        return $this->render('user/panier.html.twig', [
            'achats' => $achats,
            'controller_name' => 'UserController',
        ]);
    }
}

    /**
     * @Route("/enregistrer", name="user_register")
     * @Route("/{codeAbonne}/modify", name="user_modify")
     */
    public function register(
        Abonne $abonne = null,
        Request $request,
        ObjectManager $manager,
        UserPasswordEncoderInterface $encoder
    ) {
        if (!$abonne) {
            $abonne = new Abonne();
        }

        $form = $this->createFormBuilder($abonne)
            ->add('nomAbonne', null, [
                'label' => 'Nom*',
                'attr' => [
                    'placeholder' => 'ex: Dupont',
                    'required' => true
                ]
            ])
            ->add('prenomAbonne', null, [
                'label' => 'Prenom*',
                'attr' => [
                    'placeholder' => 'ex: Albert',
                    'required' => true
                ]
            ])
            ->add('email', null, [
                'label' => 'Email*',
                'attr' => [
                    'placeholder' => 'ex: email@email.fr',
                    'required' => true
                ]
            ])
            ->add('login', null, [
                'label' => 'Identifiant*',
                'attr' => [
                    'placeholder' => 'ex: DupontDu33',
                    'required' => true
                ]
            ])
            ->add('adresse', null, [
                'label' => 'Adresse',
                'attr' => [
                    'placeholder' => 'ex: 564 Avenue des ponts',
                    'required' => false
                ]
            ])
            ->add('codePostal', null, [
                'label' => 'Code Postal',
                'attr' => [
                    'placeholder' => 'ex: 66000',
                    'required' => false
                ]
            ])
            ->add('ville', null, [
                'label' => 'Ville',
                'attr' => [
                    'placeholder' => 'ex: Perpignan',
                    'required' => false
                ]
            ])
            ->add('codePays', null, [
                'label' => 'Pays',
                'attr' => [
                    'placeholder' => 'ex: France',
                    'required' => false
                ]
            ])
            ->add('password', PasswordType::class, [
                    'label' => 'Mot de passe*',
                    'attr' => [
                        'placeholder' => 'Mot de passe',
                        'required' => true
                    ]
                ])
            ->add('confirm_password', PasswordType::class, [
                        'label' => 'Confirmer le mot de passe*',
                        'attr' => [
                            'placeholder' => 'Confirmer le mot de passe',
                            'required' => true
                        ]
                ])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($abonne, $abonne->getPassword());
            $abonne->setPassword($hash);

            $manager->persist($abonne);
            $manager->flush();

            return $this->redirectToRoute('user_login'); 
        }

        return $this->render('user\register.html.twig', [
            'formRegister' => $form->createView()
        ]);
        
    }


    /**
     * @Route("/login", name="user_login")
     */
    public function login()
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
        return $this->render('home/home.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}
