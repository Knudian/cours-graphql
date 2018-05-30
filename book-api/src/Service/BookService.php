<?php

namespace App\Service;

use App\Bean\ClientMessage;
use App\Bean\ClientMessageError;
use App\Bean\ClientMessageInfo;
use App\Bean\ClientResponse;
use App\Constant\HttpCode;
use App\Constant\MessageCode;
use App\Exception\AuthorizationException;
use App\Exception\InvalidTokenException;
use App\Exception\NoModificationException;
use App\Exception\NullAttributeException;
use App\Factory\BookFactory;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityNotFoundException;
use Lcobucci\JWT\Token;

/**
 * Class BookService
 * @package App\Service
 */
class BookService extends BaseService
{
    /**
     * @var BookRepository
     */
    private $repository;

    /**
     * @var AuthorRepository
     */
    private $authorRepository;

    /**
     * @var BookFactory
     */
    private $factory;

    /**
     * BookService constructor.
     * @param AuthTokenService $authTokenService
     * @param BookRepository $repository
     * @param BookFactory $factory
     * @param AuthorRepository $authorRepository
     */
    public function __construct(AuthTokenService $authTokenService, BookRepository $repository, BookFactory $factory, AuthorRepository $authorRepository)
    {
        parent::__construct($authTokenService);
        $this->repository       = $repository;
        $this->authorRepository = $authorRepository;
        $this->factory          = $factory;
    }

    /**
     * @param Token $token
     * @param int $authorId
     * @param array $attributes
     * @return ClientResponse
     */
    public function create(Token $token, int $authorId, array $attributes) : ClientResponse
    {
        $clientResponse = new ClientResponse();

        try {
            $this->authTokenService->validateToken($token);
            $user = $this->authTokenService->getUserFromToken($token);
            $this->userCanModify($user);
            $author = $this->authorRepository->find($authorId);
            $book = $this->factory->make($author, $attributes);
            $clientResponse->setHttpCode(HttpCode::CREATED)
                ->setResponse(
                    new ClientMessage(
                        ClientMessage::STANDARD,
                        MessageCode::CREATED,
                        $book->jsonSerialize()
                    )
                );
        } catch (NullAttributeException $e) {
            $clientResponse->setHttpCode(HttpCode::BAD_REQUEST)
                ->addMessage(
                    new ClientMessageError(
                        MessageCode::NULL_ATTRIBUTE,
                        $e->getParams()
                    )
                );
        } catch (AuthorizationException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::UNAUTHORIZED)
                ->addMessage(
                    new ClientMessageError(MessageCode::INSUFFICIENT_RIGHTS)
                );
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        }

        return $clientResponse;
    }

    /**
     * @param Token $token
     * @param int $id
     * @param array $attributes
     * @return ClientResponse
     */
    public function update(Token $token, int $id, array $attributes) : ClientResponse
    {
        $clientResponse = new ClientResponse();

        try {
            $this->authTokenService->validateToken($token);
            $user = $this->authTokenService->getUserFromToken($token);
            $this->userCanModify($user);

            $book = $this->repository->find($id);
            $book = $this->factory->update($book, $attributes);
            $clientResponse->setHttpCode(HttpCode::ACCEPTED)
                ->setResponse(
                    new ClientMessage(
                        ClientMessage::STANDARD,
                        MessageCode::UPDATED,
                        $book->jsonSerialize()
                    )
                );
        } catch (NoModificationException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::NOTHING_CHANGED)
                ->addMessage(
                    new ClientMessageInfo(MessageCode::NOTHING_CHANGED)
                );
        } catch (AuthorizationException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::UNAUTHORIZED)
                ->addMessage(
                    new ClientMessageError(MessageCode::INSUFFICIENT_RIGHTS)
                );
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        }

        return $clientResponse;
    }

    /**
     * @param Token $token
     * @param int $id
     * @return ClientResponse
     */
    public function find(Token $token, int $id) : ClientResponse
    {
        $clientResponse = new ClientResponse();
        try {
            $this->authTokenService->validateToken($token);
            $book = $this->repository->find($id);
            if (is_null($book))
                throw new EntityNotFoundException();
            $clientResponse
                ->setHttpCode(HttpCode::OK)
                ->addMessage(
                    new ClientMessage(
                        ClientMessage::STANDARD,
                        MessageCode::NONE,
                        $book->jsonSerialize()
                    )
                );
        } catch (EntityNotFoundException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::NOT_FOUND)
                ->addMessage(
                    new ClientMessageError(MessageCode::NOT_FOUND)
                );
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        }
        return $clientResponse;
    }

    /**
     * @param Token $token
     * @param string $key
     * @param string $value
     * @return ClientResponse
     */
    public function findBy(Token $token, string $key = 'id', string $value = ''): ClientResponse
    {
        $clientResponse = new ClientResponse();
        try {
            $this->authTokenService->validateToken($token);
            $books = $this->repository->findBy([$key => $value]);
            $clientResponse
                ->setHttpCode(HttpCode::OK)
                ->addMessage(
                    new ClientMessage(
                        ClientMessage::STANDARD,
                        MessageCode::NONE,
                        $books
                    )
                );
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        } catch (\Exception $e) {
            $clientResponse
                ->setHttpCode(HttpCode::BAD_REQUEST)
                ->addMessage(
                    new ClientMessageError(MessageCode::BAD_REQUEST)
                );
        }

        return $clientResponse;
    }

    /**
     * @param Token $token
     * @return ClientResponse
     */
    public function all(Token $token): ClientResponse
    {
        $clientResponse = new ClientResponse();
        try {
            $this->authTokenService->validateToken($token);
            $books = $this->repository->findAll();
            $clientResponse
                ->setHttpCode(HttpCode::OK)
                ->addMessage(
                    new ClientMessage(
                        ClientMessage::STANDARD,
                        MessageCode::NONE,
                        $books
                    )
                );
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        } catch (\Exception $e) {
            $clientResponse
                ->setHttpCode(HttpCode::BAD_REQUEST)
                ->addMessage(
                    new ClientMessageError(MessageCode::BAD_REQUEST)
                );
        }
        return $clientResponse;
    }

    /**
     * @param Token $token
     * @param int $id
     * @return ClientResponse
     */
    public function delete(Token $token, int $id): ClientResponse
    {
        $clientResponse = new ClientResponse();

        try {
            $this->authTokenService->validateToken($token);
            $user = $this->authTokenService->getUserFromToken($token);
            $this->userCanModify($user);
            $book = $this->repository->find($id);
            $this->factory->delete($book);
            $clientResponse
                ->setHttpCode(HttpCode::ACCEPTED);
        } catch (InvalidTokenException $e) {
            $clientResponse
                ->setHttpCode(HttpCode::FORBIDDEN)
                ->addMessage(
                    new ClientMessageError(MessageCode::TOKEN_EXPIRED)
                );
        } catch (\Exception $e) {
            $clientResponse
                ->setHttpCode(HttpCode::BAD_REQUEST)
                ->addMessage(
                    new ClientMessageError(MessageCode::BAD_REQUEST)
                );
        }
        return $clientResponse;
    }
}