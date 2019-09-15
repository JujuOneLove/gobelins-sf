<?php

namespace App\Controller;

use App\Entity\Album;
use App\Form\AlbumType;
use App\Repository\AlbumRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * @Route("/album")
 */
class AlbumController extends AbstractController
{
    /**
     * @Route("/", name="album_index", methods={"GET"})
     * @param AlbumRepository $albumRepository
     * @param UserRepository $userRepository
     * @param TokenStorageInterface $token
     * @return Response
     */
    public function index(AlbumRepository $albumRepository, UserRepository$userRepository,TokenStorageInterface $token): Response
    {
        return $this->render('album/index.html.twig', [
            'albums' => $albumRepository->findAll(),
            'user' => $userRepository->find($token->getToken()->getUser()->getId())
        ]);
    }

    /**
     * @Route("/new", name="album_new", methods={"GET","POST"})
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($album);
            $entityManager->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/new.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="album_show", methods={"GET"})
     * @param Album $album
     * @return Response
     */
    public function show(Album $album): Response
    {
        return $this->render('album/show.html.twig', [
            'album' => $album,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="album_edit", methods={"GET","POST"})
     * @param Request $request
     * @param Album $album
     * @return Response
     */
    public function edit(Request $request, Album $album): Response
    {
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('album_index');
        }

        return $this->render('album/edit.html.twig', [
            'album' => $album,
            'form' => $form->createView(),
        ]);
    }
}
