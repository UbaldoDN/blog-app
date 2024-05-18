<?php

namespace App\Services\HttpClients\JsonPlaceHolder;

use App\Services\HttpClients\JsonPlaceHolder\Clients\AuthorClient;

final class AuthorHttpClientsService
{
    public function __construct(protected AuthorClient $authorsClient)
    {
        //
    }

    public function getPosts($authorId)
    {
        return $this->authorsClient->getPosts($authorId);
    }

    public function getPost($id, $authorId)
    {
        return $this->authorsClient->getPost($id, $authorId);
    }

    public function storePost($authorId, $title, $body)
    {
        return $this->authorsClient->storePost($authorId, $title, $body);
    }

    public function updatePost($id, $authorId, $title, $body)
    {
        return $this->authorsClient->updatePost($id, $authorId, $title, $body);
    }
}
