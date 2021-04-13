<?php

namespace App\Entity;

use App\Api\callApi;
use App\Repository\BooksRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BooksRepository::class)
 */
class Books
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="array")
     */
    public $author;

    /**
     * @ORM\Column(type="array")
     */
    private $category;

    /**
     * @ORM\Column(type="date")
     */
    private $publication;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $summary;


    /**
     * @ORM\Column(type="integer")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $googleBookId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param array $author
     * @return array
     */
    public function setAuthor(array $author): array
    {
        return $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory(array $category): array
    {
        return $this->category = $category;
    }

    public function getPublication(): ?\DateTimeInterface
    {
        return $this->publication;
    }

    public function setPublication(\DateTimeInterface $publication): self
    {
        $this->publication = $publication;

        return $this;
    }

    public function getSummary(): ?string
    {
        return $this->summary;
    }

    public function setSummary(string $summary): self
    {
        $this->summary = $summary;

        return $this;
    }




    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getGoogleBookId(): ?string
    {
        return $this->googleBookId;
    }

    public function setGoogleBookId(string $googleBookId): self
    {
        $this->googleBookId = $googleBookId;

        return $this;
    }

    public function getBook(callApi $callApi, string $name)
    {
        $books = $callApi->getBookData($name);
        $listBook = json_decode($books);
        $arrayBook = [];
        foreach ($listBook->items as $item) {
            $newBook = new Books();

            $newBook->setName($item->volumeInfo->title);
            $newBook->setGoogleBookId($item->id);

            if (isset($item->volumeInfo->authors) && isset($item->volumeInfo->categories)) {
                $newBook->setAuthor($item->volumeInfo->authors);
                $newBook->setCategory($item->volumeInfo->categories);

                $newBook->setPublication(new \DateTime($item->volumeInfo->publishedDate));
                $item = $newBook;

                array_push($arrayBook, $item);
            }

        }
        return $arrayBook;
    }

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }


}
