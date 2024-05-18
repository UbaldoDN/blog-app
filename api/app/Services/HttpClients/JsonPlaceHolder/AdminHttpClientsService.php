<?php

namespace App\Services\HttpClients\JsonPlaceHolder;

use App\Services\HttpClients\JsonPlaceHolder\Clients\AdminClient;

final class AdminHttpClientsService
{
    public function __construct(protected AdminClient $adminsClient)
    {
        //
    }

    public function getAllAuthors()
    {
        return $this->adminsClient->getAllAuthors();
    }

    public function getAuthor(int $authorId)
    {
        return $this->adminsClient->getAuthor($authorId);
    }

    public function getAuthorPosts(int $authorId)
    {
        return $this->adminsClient->getAuthorPosts($authorId);
    }

    public function storeAuthor(string $name, string $email)
    {
        return $this->adminsClient->storeAuthor($name, $email);
    }

    public function updateAuthor(int $authorId, string $name, string $email)
    {
        return $this->adminsClient->updateAuthor($authorId, $name, $email);
    }

    public function approvePost(int $id)
    {
        return $this->adminsClient->approvePost($id);
    }
}
