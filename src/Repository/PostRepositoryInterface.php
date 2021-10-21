<?php

namespace App\Repository;

use App\Entity\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface PostRepositoryInterface
{
    /**
     * @return array
     */
    public function getAllPost(): array;

    /**
     * @param int $postId
     * @return object
     */
    public function getOnePost(int $postId): object;

    /**
     * @param Post $post
     * @param UploadedFile $image
     * @return object
     */
    public function setCreatePost(Post $post, UploadedFile $image): object;

    /**
     * @param Post $post
     * @param UploadedFile $image
     * @return object
     */
    public function setUpdatePost(Post $post, UploadedFile $image): object;

    /**
     * @param Post $post
     */
    public function setDeletePost(Post $post);

    /**
     * @param int $categoryId
     * @return mixed
     */
    public function getPostFilterJson(int $categoryId): array;
}