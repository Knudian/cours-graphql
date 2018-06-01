<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BookCommentRepository")
 */
class BookComment
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $content;

    /**
     * @var Book
     * @ORM\ManyToOne(targetEntity="App\Entity\Book", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $rate = 5;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="bookComments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * BookComment constructor.
     */
    public function __construct()
    {
        $this->createAt = new DateTime();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

    /**
     * @return null|string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param null|string $content
     * @return BookComment
     */
    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return Book
     */
    public function getBook(): Book
    {
        return $this->book;
    }

    /**
     * @param Book $book
     * @return BookComment
     */
    public function setBook(Book $book): self
    {
        $this->book = $book;
        return $this;
    }

    /**
     * @return int
     */
    public function getRate(): int
    {
        return $this->rate;
    }

    /**
     * @param int $rate
     * @return BookComment
     */
    public function setRate(int $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return BookComment
     */
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
}
