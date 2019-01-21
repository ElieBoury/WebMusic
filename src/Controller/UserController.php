<?php

namespace App\Controller;

use App\Entity\Enregistrement;
use App\Entity\Achat;
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
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/{codeAbonne}/panier", name="user_panier1")
     */
    public function panier(Abonne $abonne, AbonneRepository $abonneRepo)
    {

        $abo = $this->getDoctrine()->getRepository(Abonne::class)->findOneBy(['codeAbonne'=>$abonne->getCodeAbonne()]);

        if (isset($_POST['enregistrement'])) {
            $enregistrement = $this->getDoctrine()->getRepository(Enregistrement::class)
                ->findOneBy(['codeMorceau' => $_POST['enregistrement']]);
            $entityManager = $this->getDoctrine()->getManager();
            $achat = new Achat();
            $achat->setCodeAbonne($abo);
            $achat->setCodeEnregistrement($enregistrement/*$enregistrement->getCodeMorceau()*/);
            $achat->setAchatConfirme(0);
            $entityManager->persist($achat);
            $entityManager->flush();

        }
        $achats = $abonneRepo->achatsNonConfirmes($abo);
        $enregistrements = $abonneRepo->titreEnregistrementAchat($abonne);
        return $this->render('user/panier.html.twig', [
            'achats' => $achats,
            'controller_name' => 'UserController',
            'enregistrements'=>$enregistrements,'history' =>false
        ]);
    }
    /**
     * @Route("/{codeAbonne}/panier",name="confirmation_achats")
     */
    public function confirmationAchats(Abonne $abonne,AbonneRepository $abonneRepo){
    $achats =$this->getDoctrine()->getRepository(Achat::class)->findBy(array('codeAbonne'=>$abonne->getCodeAbonne()));
//        array('achatConfirme'=>0));
//    $achats=$this->getDoctrine()->getRepository()
//    foreach ($achats as $achat){
//        $achat->
////    }
    $abo = $this->getDoctrine()->getRepository(Abonne::class)->findOneBy(['codeAbonne'=>$abonne->getCodeAbonne()]);
    $abonneRepo->acheterEnregistrements($abonne);
        $achats = $abonneRepo->achatsNonConfirmes($abo);
        $enregistrements = $abonneRepo->titreEnregistrementAchat($abonne);
        return $this->render('user/panier.html.twig', [
            'achats' => $achats,
            'controller_name' => 'UserController',
            'enregistrements'=>$enregistrements,'history' =>false
        ]);
    }
    /**
     * @Route("/{codeAbonne}/panier",name="delete_achats")
     */
    public function deleteAchats(Abonne $abonne,AbonneRepository $abonneRepo){
        $achats =$this->getDoctrine()->getRepository(Achat::class)->findBy(array('codeAbonne'=>$abonne->getCodeAbonne()),
      array('achatConfirme'=>0));
//    $achats=$this->getDoctrine()->getRepository()
//    foreach ($achats as $achat){
//        $achat->
////    }
        $abo = $this->getDoctrine()->getRepository(Abonne::class)->findOneBy(['codeAbonne'=>$abonne->getCodeAbonne()]);
        $abonneRepo->acheterEnregistrements($abonne);
       // $achats = $abonneRepo->achatsNonConfirmes($abo);
        foreach($achats as $achat) {
            $this->getDoctrine()->getManager()->remove($achat);
        }
        $achats=$abonneRepo->achatsNonConfirmes();
            $enregistrements = $abonneRepo->titreEnregistrementAchat($abonne);
        return $this->render('user/panier.html.twig', [
            'achats' => $achats,
            'controller_name' => 'UserController',
            'enregistrements'=>$enregistrements,'history' =>false
        ]);
    }

    /**
     * @Route("/{codeAchat}/enregistrement",name="achat_enregistrement")
     */
    public function enregistrement(Achat $achat,AbonneRepository $abonneRepo) : Response{
        $response = new Response();

        $response->setContent($abonneRepo->enregistrementAchat($achat));
        return $response;
    }

    /**
     * @Route("/{codeAbonne}/history", name="historique_achats")
     */
    public function historiqueAchats(Abonne $abonne, AbonneRepository $abonneRepo){
        $achats=$abonneRepo->achatsPrecedents($abonne);
        $enregistrements = $abonneRepo->titreEnregistrementAchatPrec($abonne);
        return $this->render('user/panier.html.twig',[
            'achats'=> $achats, 'titre'=>"Historique des achats", 'enregistrements' =>$enregistrements,'history'=>true
        ]);
    }

    /**
     * *  @Route("/panier", name="user_panier")
     */
    public function panierDisconnect()
    {
        return $this->render('user/panier.html.twig', [
            'achats' => null,
            'controller_name' => 'UserController',
        ]);
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
    )
    {
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

        if ($form->isSubmitted() && $form->isValid()) {
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
