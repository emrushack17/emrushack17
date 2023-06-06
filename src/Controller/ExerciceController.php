<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExerciceController extends AbstractController
{
    #[Route('/order/{maVar}', name: 'app_test')]
    public function testMaVar($maVar){
        return new Response("
            <html><body>$maVar</body></html>
        ");
    }


    #[Route('/exer', name: 'app_exer')]
    public function index(): Response
    {
        return $this->render('home/exercice.html.twig', [
            'name' => 'HomeController',
        ]);
    }

    #[Route('/exer2/{name}', name: 'app_exer2')]
    public function index2(Request $request, $name): Response
    {
        return $this->render('home/exer2.html.twig', 
        ['nom' => $name]);  
    }

    #[Route('multi/{ent1<\d+>}/{ent2<\d+>}', name: 'mi.app')]
    public function multiplication($ent1, $ent2) {

        $res = $ent1 * $ent2;
        return new Response("<h1>$res</h1>");

    }
}