<?php

namespace App\Controller;

use App\Entity\BrandNew;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BrandNewController extends AbstractController
{
    #[Route('/brand/new', name: 'app_brand_new')]
    public function index(ManagerRegistry $doctrin): Response
    {
        $entityManager  = $doctrin->getManager();
         $product = new BrandNew();
         $product->setName('nazanin');
         $product->setLastname('mirzaee');
         $entityManager->persist($product);
         $entityManager->flush();
         return new Response('Saved new product with id '.$product->getId());

        // return $this->render('brand_new/index.html.twig', [
        //     'controller_name' => 'BrandNewController',
        // ]);
    }
}
