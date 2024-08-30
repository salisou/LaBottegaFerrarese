<?php

namespace App\Controller;

use App\Form\ModificaPasswordUserType;
use App\Form\PasswordUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(): Response
    {

        return $this->render('account/index.html.twig');
    }

    // #[Route('/account/modifica-password', name: 'modifica_password_account')]
    // public function modificaPassword(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    // {
    //     //Recupero l'utente attualmente autenticato
    //     $user = $this->getUser();

    //     // Verrifica se l'utent è autenticato se non manda un messaggio 
    //     if (!$user) {
    //         $this->addFlash('error', 'Devi essere autenticato per accedere a
    //         questa pagina');
    //         return $this->redirectToRoute('app_login');
    //     }



    //     // Crea la forma per modificarre la password, 
    //     // passando l'utente e il servizio di hashing della password
    //     $form = $this->createForm(PasswordUserType::class, $user, [
    //         'userPasswordHasher' => $userPasswordHasher
    //     ]);

    //     //Recupero i dati dal form
    //     $form->handleRequest($request);

    //     // verrifica se la forma è stata compilata crenttamente e se è valida
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         //aggiorna il db
    //         $entityManager->flush();
    //     }


    //     return $this->render('account/modifica_password.html.twig', [
    //         'formModificaPassword' => $form->createView()
    //     ]);
    // }

    #[Route('/modifica_password', name: 'app_modificaPassword')]
    public function modificaPassword(Request  $request, UserPasswordHasherInterface  $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        // Verrifica se l'utent è autenticato se non manda un messaggio
        if (!$user) {
            $this->addFlash('error', 'Devi essere autenticato per accedere a
            questa pagina');
            return $this->redirectToRoute('app_login');
        }

        // Crea la forma per modificarre la password,
        // passando l'utente e il servizio di hashing della password
        $form = $this->createForm(ModificaPasswordUserType::class, $user, [
            'userPasswordHasher' => $userPasswordHasher
        ]);

        // Ascolta la richiesta di symfony 
        $form->handleRequest($request);

        // verrifica se la forma è stata compilata crenttamente e se è valida
        if ($form->isSubmitted() && $form->isValid()) {
            // Recupero i dati dal form
            // dd($form->getData());

            // Aggiorna il db
            $entityManager->flush();
            // messagio flash 
            $this->addFlash('success', 'La password è stata modificata con successo');

            // redirect
            return $this->redirectToRoute('app_login');
        }
        return $this->render('account/modifica_password.html.twig', [
            'formModificaPassword' => $form->createView()
        ]);
    }
}
