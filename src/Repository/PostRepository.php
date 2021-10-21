<?php

namespace App\Repository;

use App\Entity\Post;
use App\Service\FileManagerServiceInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository implements PostRepositoryInterface
{
    private $entityManager;
    private $fileManager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager, FileManagerServiceInterface $fileManagerService)
    {
        $this->entityManager = $manager;
        $this->fileManager = $fileManagerService;
        parent::__construct($registry, Post::class);
    }

    public function getAllPost(): array
    {
        return parent::findAll();
    }

    public function getOnePost(int $postId): object
    {
        return parent::find($postId);
    }

    public function setCreatePost(Post $post, UploadedFile $image): object
    {
        if ($image) {
            $imageName = $this->fileManager->uploadPostImage($image);
            $post->setImage($imageName);
        }
        $post->setCreateAtValue();
        $post->setUpdateAtValue();
        $post->setIsPublished();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    public function setUpdatePost(Post $post, UploadedFile $image): object
    {
        $oldImage = $post->getImage();
        if ($image) {
            if ($oldImage) {
                $this->fileManager->removePostImage($oldImage);
            }
            $imageName = $this->fileManager->uploadPostImage($image);
            $post->setImage($imageName);
        }
        $post->setUpdateAtValue();
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }

    public function setDeletePost(Post $post)
    {
        $imageName = $post->getImage();
        if ($imageName) {
            $this->fileManager->removePostImage($imageName);
        }
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    public function getPostFilterJson(int $categoryId): array
    {
        $db = $this->createQueryBuilder('post')
            ->innerJoin('post.category', 'category')
            ->select('post.id', 'post.title', 'post.content', 'category.title')
            ->where('category.id = :id')
            ->setParameter(':id', $categoryId)
            ;

        $query = $db->getQuery();
        return $query->execute();
    }
}
