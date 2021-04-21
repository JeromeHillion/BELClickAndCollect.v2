<?php


namespace App\Controller;


use App\Entity\Books;
use App\Repository\BooksRepository;
use App\Service\Api\callApi;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
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
    public function addBook(callApi $callApi, string $id, BooksRepository $booksRepository)
    {
        $bookDatas = $callApi->getBookById($id);
        $bookData = json_decode($bookDatas);
        $newBook = new Books();

if ($booksRepository->findOneBy(['googleBookId'=> $id])){

    /*$response = new Response();
    return $response->setStatusCode(409, "Le livre existe déjà en base de données");*/



}
     $newBook->setName($bookData->volumeInfo->title);
            $newBook->setGoogleBookId($bookData->id);

            if (isset($bookData->volumeInfo->authors) && isset($bookData->volumeInfo->categories) && isset($bookData->volumeInfo->imageLinks->thumbnail) && isset($bookData->volumeInfo->description) && isset($bookData->volumeInfo->publishedDate) ) {
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


        return $this->json([
            'code' => 200,
            'message' => 'Le livre a bien été ajouté !',
            'id' => $id
        ]);
    }

    /**
     * @Route("/admin/livres", name="list_books")
     */
    public function listBook(BooksRepository $repository)
    {
        $books = $repository->findAll();

        return $this->render('/admin/listbook.html.twig',[
            "books" => $books
        ]);

    }

    /**
     * @Route("/admin/deleteBook/{id}", name="delete_book")
     */
    public function deleteBook(BooksRepository $booksRepository, int $id){

        $entityManager = $this->getDoctrine()->getManager();
        $book = $booksRepository->find($id);

        $entityManager->remove($book);
        $entityManager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'Le livre a bien été supprimé !',
            'id' => $id
        ]);
    }

}