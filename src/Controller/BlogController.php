<?php

namespace App\Controller;

use App\Entity\Blog;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


class BlogController extends AbstractController
{


    #[Route('/blog/add', name: 'app_blog',methods:['POST'])]
    public function add(string $tiitle,string $body ,ManagerRegistry  $doctrine) 
    {
          $entityManager  = $doctrine->getManager();
          
        $blog = new Blog();
        $blog->setTitle($tiitle);
        $blog->setBody($body);

      
        $entityManager->persist($blog);
        
        $entityManager->flush();

        return new JsonResponse('Saved new product with id ');
   
      
    }


    #[Route('/blog/show/{blog}', name: 'app_blog_show',methods: ['GET'])]
    public function show(Blog $blog,EntityManagerInterface $entityManage)
    {
        
          $repository = $entityManage->getRepository(Blog::class);
         $service = $repository->findOneBy(['blog' => $blog]);
         
         //dd($service);

        return [
           'title' => $blog->getId(),
           'body' => $blog ->getBody(),
        
        ];
                   
    }

    #[Route('/blog/delete/{id}', name: 'app_blog_delete',methods: ['GET'])]
    public function delete($id,ManagerRegistry  $doctrine){
        $entityManager  = $doctrine->getManager();
       $service = $doctrine->getRepository(Blog::class);
      $eml = $service->find($id);
      $entityManager->remove($eml);
      $entityManager->flush();
        return new JsonResponse('deleted');
    }


 
}
