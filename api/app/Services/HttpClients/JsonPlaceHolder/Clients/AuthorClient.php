<?php

namespace App\Services\HttpClients\JsonPlaceHolder\Clients;

use App\Services\HttpClients\JsonPlaceHolder\Abstract\ApiService;

class AuthorClient extends ApiService
{
    public function __construct()
    {
        parent::__construct('https://jsonplaceholder.typicode.com');
    }

    public function getMyInfo($authorId)
    {
        return $this->getRequest("/users/{$authorId}");
    }

    public function getPosts($authorId)
    {
        return $this->getRequest("/users/{$authorId}/posts");
    }

    public function getPost($id, $authorId)
    {
        $authorPosts = [];
        $post        = $this->getRequest("/posts/{$id}");
        if ($post && $post['userId'] === $authorId) {
            $authorPosts = [
                'author' => [
                    ...$this->getMyInfo($authorId),
                    'posts' => $post,
                ],
            ];
        }

        return $authorPosts;
    }

    public function storePost($authorId, $title, $body)
    {
        $data = [
            'userId' => $authorId,
            'title'  => $title,
            'body'   => $body,
        ];

        return $this->postRequest('/posts', $data);
    }

    public function updatePost($id, $authorId, $title, $body)
    {
        $post = $this->getRequest("/posts/{$id}");
        if ($post && $post['userId'] === $authorId) {
            $data = [
                'userId' => $authorId,
                'title'  => $title,
                'body'   => $body,
            ];
            
            return $this->putRequest("/posts/{$id}", $data);
        }

        return null;
    }
}
