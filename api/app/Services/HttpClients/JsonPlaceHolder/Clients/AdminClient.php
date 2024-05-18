<?php

namespace App\Services\HttpClients\JsonPlaceHolder\Clients;

use App\Services\HttpClients\JsonPlaceHolder\Abstract\ApiService;
use Carbon\Carbon;

class AdminClient extends ApiService
{
    public function __construct()
    {
        parent::__construct('https://jsonplaceholder.typicode.com');
    }

    public function getAllAuthors()
    {
        return $this->getRequest('/users');
    }

    public function getAuthor($authorId)
    {
        return $this->getRequest("/users/{$authorId}");
    }

    public function getAuthorPosts($authorId)
    {
        $authorPosts = [];
        $posts       = $this->getRequest("/users/{$authorId}/posts");
        if ($posts) {
            $authorPosts = [
                'author' => [
                    ...$this->getAuthor($authorId),
                    'posts' => $posts,
                ],
            ];
        }

        return $authorPosts;
    }

    public function storeAuthor($name, $email)
    {
        return $this->postRequest("/users", [
            'name'  => $name,
            'email' => $email,
        ]);
    }

    public function updateAuthor($authorId, $name, $email)
    {
        return $this->putRequest("/users/{$authorId}", [
            'name'  => $name,
            'email' => $email,
        ]);
    }

    public function approvePost($id)
    {
        return $this->patchRequest("/posts/{$id}", [
            'approved'     => true,
            'published_at' => Carbon::now(),
        ]);
    }
}
