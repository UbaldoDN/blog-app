<?php

namespace App\Services\HttpClients\JsonPlaceHolder\Clients;

use App\Services\HttpClients\JsonPlaceHolder\Abstract\ApiService;

class PostClient extends ApiService
{
    public function __construct()
    {
        parent::__construct('https://jsonplaceholder.typicode.com');
    }

    public function getAll()
    {
        return $this->getRequest('/posts?_limit=15');
    }

    public function getById($id)
    {
        $post = $this->getRequest("/posts/{$id}");
        if ($post) {
            $post['author'] = $this->getAuthorInfo($post['userId']);
        }

        return $post;
    }

    private function getAuthorInfo($authorId)
    {
        return $this->getRequest("/users/{$authorId}");
    }
}
