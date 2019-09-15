<?php

namespace App\Controller;

use App\Form\SearchType;
use App\Repository\GifRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index", methods={"GET","POST"})
     */
    public function index(Request $request, GifRepository $gifRepository): Response
    {
        $form = $this->createForm(SearchType::class);
        $form->handleRequest($request);
        $gifs = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $result = $form["query"]->getData();
            foreach ($gifRepository->findAll() as $album){
                if(strpos($album->getTag(), $result) !==false){
                    $gifs[] = $album;
                }
            }
        }
        return $this->render('index/index.html.twig', [
            'gifs' => $gifs,
            'form' => $form->createView(),
        ]);
    }
}
