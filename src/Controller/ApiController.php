<?php


namespace App\Controller;


use App\Api\callApi;
use App\Entity\Books;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class ApiController extends abstractController
{
    /**
     * @Route("/admin/api/reqSearchBooksApi", name="admin_searchBooksApi")
     */
    public function search()
    {

        return $this->render('/admin/api/reqSearchBooksApi.html.twig');

    }

    /**
     * @Route("/admin/api/reqSearchBooksApi/{name}")
     */
    public function reqSearchBooksApi(callApi $callApi, string $name)
    {
        $books = $callApi->getBookData($name);
        $listBook = json_decode($books);
        $arrayBook = [];

        $newBook = new Books();
        /*dd($listBook->items);*/
        foreach ($listBook->items as $item) {

            $newBook->setName($item->volumeInfo->title);


            if (isset($item->volumeInfo->authors) && isset($item->volumeInfo->categories)) {
                $newBook->setAuthor($item->volumeInfo->authors);
                $newBook->setCategory($item->volumeInfo->categories);
            } else {
                $newBook->setCategory([]);
                $newBook->setAuthor([]);
            }


             $newBook->setPublication(new \DateTime($item->volumeInfo->publishedDate));
$item = $newBook;
            array_push($arrayBook, $item);
        }
        /*dd($arrayBook);*/


        return $this->json([
            'code' => 200,
            'message' => 'Livres trouvées !',
            'books' => $arrayBook
            /*   'bookTitle' => $bookTitle*/
        ], 200);

    }


}