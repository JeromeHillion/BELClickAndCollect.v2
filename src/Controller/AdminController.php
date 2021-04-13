<?php


namespace App\Controller;

use App\Api\callApi;
use App\Entity\Books;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function dashboard()
    {

        return $this->render('/admin/dashboard.html.twig');
    }

    /**
     * @Route("/admin/addBook/{id}", name="add_book")
     */
    public function addBook(callApi $callApi, string $id)
    {
        $bookDatas = $callApi->getBookById($id);
        /*dd($book);*/
        $bookData = json_decode($bookDatas);
        $newBook = new Books();
        foreach ($bookData->volumeInfo as $data) {

            $newBook->setName($bookData->volumeInfo->title);
            $newBook->setGoogleBookId($bookData->id);

            if (isset($bookData->volumeInfo->authors) && isset($bookData->volumeInfo->categories) && isset($bookData->volumeInfo->publishedDate)) {
                $newBook->setAuthor($bookData->volumeInfo->authors);
                $newBook->setCategory($bookData->volumeInfo->categories);
                $newBook->setCover($bookData->volumeInfo->imageLinks->thumbnail);
                $newBook->setSummary(strip_tags($bookData->volumeInfo->description));
                $newBook->setQuantity(5);

                $newBook->setPublication(new \DateTime($bookData->volumeInfo->publishedDate));
                $item = $newBook;

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($item);
                $entityManager->flush();
            }

        }
        //On redirige vers la page des livres
        return $this->redirectToRoute("list_books");
    }

    /**
     * @Route("/admin/livres", name="list_books")
     */
    public function listBook()
    {

        return $this->render('/admin/listbook.html.twig');

    }

}