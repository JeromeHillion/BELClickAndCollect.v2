<?php


namespace App\Controller;


use App\Entity\User;
use App\Repository\BooksRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainController extends abstractController
{


    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index()
    {

        //On vérifie que notre utilisateur est bien connecté sinon on le redirige sur la page de connexion
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('security_login');
        }

        return $this->render('library/index.html.twig');
    }
    /**
     * @Route("/library/ma-bibliotheque", name="library")
     * @return Response
     */
    public function library()
    {

        //On vérifie que notre utilisateur est bien connecté sinon on le redirige sur la page de connexion
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('security_login');
        }



        return $this->render('library/library.html.twig');
    }

    /**
     * @Route("/library/rechercher", name="search")
     * @return Response
     */
    public function search()
    {

        //On vérifie que notre utilisateur est bien connecté sinon on le redirige sur la page de connexion
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('security_login');
        }



        return $this->render('library/search.html.twig');
    }

    /**
     * @Route("/library/livres" , name="books")
     */

    public function books(BooksRepository $booksRepository){

        $books= $booksRepository->findAll();

        return $this->render('library/books.html.twig',[
            "books" => $books
        ]);
    }

    /**
     * @Route("/library/livres/details/{id}", name="book_details")
     */

    public function book_details($id, BooksRepository $booksRepository){

        $book = $booksRepository->find($id);

       return $this->render('library/book_details.html.twig', [
           'book' => $book
       ]);
    }
}