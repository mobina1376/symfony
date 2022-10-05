<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/posts/add', name: 'posts_add',methods:['POST'])]
    public function add(ManagerRegistry  $doctrine,Request $request) 
    {
          $entityManager  = $doctrine->getManager();
          $title = $request->get('title');
          $body = $request->get('body');
          
        $blog = new Blog();
        $blog->setTitle($title);
        $blog->setBody($body);
        $entityManager->persist($blog);
        $entityManager->flush();

        return new JsonResponse(
              [
                'status' => 'true',
                'message' => 'saved',
              ]
        );
    }


    #[Route('/posts/{postid}', name: 'posts_show',methods: ['GET'])]
    public function show(int $postId,ManagerRegistry  $doctrine)
    {
         $repository = $doctrine->getRepository(Blog::class);
         $blog = $repository->find($postId);

        return  new JsonResponse([
           'title' => $blog->getId(),
           'body' => $blog ->getBody(),
        ]);             
    }

    #[Route('/posts/{postid}/delete', name: 'posts_delete',methods: ['GET'])]
    public function delete(int $postid,ManagerRegistry  $doctrine)
    {
      $entityManager  = $doctrine->getManager();
      $repository = $doctrine->getRepository(Blog::class);
      $blog = $repository->find($postid);
      $entityManager->remove($blog);
      $entityManager->flush();
        return new JsonResponse([
            'status' => true,
            'mesage' => 'deleted',
        ]);
    }
}
