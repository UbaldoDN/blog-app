<?php

namespace App\Services\HttpClients\JsonPlaceHolder;

use App\Services\HttpClients\JsonPlaceHolder\Clients\PostClient;

final class PostsHttpClientsService
{
    public function __construct(protected PostClient $postsClient)
    {
        //
    }

    public function getAll()
    {
        return $this->postsClient->getAll();
    }

    public function getById($id)
    {
        return $this->postsClient->getById($id);
    }
}
