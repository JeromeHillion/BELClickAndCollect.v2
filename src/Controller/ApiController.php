<?php


namespace App\Controller;


use App\Service\Api\callApi;
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

        foreach ($listBook->items as $item) {
            $newBook = new Books();

            $newBook->setName($item->volumeInfo->title);
            $newBook->setGoogleBookId($item->id);

            if (isset($item->volumeInfo->authors) && isset($item->volumeInfo->categories) && isset($item->volumeInfo->imageLinks->thumbnail) && isset($item->volumeInfo->description) && isset($item->volumeInfo->publishedDate) ) {
                $newBook->setAuthor($item->volumeInfo->authors);
                $newBook->setCategory($item->volumeInfo->categories);
                $newBook->setCover($item->volumeInfo->imageLinks->thumbnail);
                $newBook->setSummary($item->volumeInfo->description);

                $newBook->setPublication(new \DateTime($item->volumeInfo->publishedDate));


                array_push($arrayBook, $newBook);
            }

            /*dd($arrayBook);*/
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