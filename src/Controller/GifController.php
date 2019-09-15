<?php

namespace App\Controller;

use App\Entity\Gif;
use App\Form\GifType;
use App\Repository\GifRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * @Route("/gif")
 */
class GifController extends AbstractController
{
    /**
     * @Route("/", name="gif_index", methods={"GET"})
     */
    public function index(GifRepository $gifRepository): Response
    {
        return $this->render('gif/index.html.twig', [
        'gifs' => $gifRepository->findAll(),
    ]);
    }

    /**
     * @Route("/new", name="gif_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gif = new Gif();
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gif);
            $entityManager->flush();

            return $this->redirectToRoute('gif_index');
        }

        return $this->render('gif/new.html.twig', [
            'gif' => $gif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gif_show", methods={"GET"})
     */
    public function show(Gif $gif): Response
    {
        return $this->render('gif/show.html.twig', [
            'gif' => $gif,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="gif_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gif $gif): Response
    {
        $form = $this->createForm(GifType::class, $gif);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('gif_index');
        }

        return $this->render('gif/edit.html.twig', [
            'gif' => $gif,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/addfavorite", name="gif_addfavorite")
     */
    public function addfavorite(Gif $gif,UserRepository$userRepository,TokenStorageInterface $token): Response
    {
        $currentUser = $token->getToken()->getUser()->getId();
        if($currentUser !== null){
            $user = $userRepository->find($token->getToken()->getUser()->getId());
            $user->addFavorite($gif);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('album_index');
    }
    /**
     * @Route("/{id}/deletefavorite", name="gif_deletefavorite")
     */
    public function deletefavorite(Gif $gif,UserRepository$userRepository,TokenStorageInterface $token): Response
    {
        $currentUser = $token->getToken()->getUser()->getId();
        if($currentUser !== null){
            $user = $userRepository->find($token->getToken()->getUser()->getId());
            $user->removeFavorite($gif);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('album_index');
    }
    /**
     * @Route("/{id}", name="gif_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gif $gif): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gif->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gif);
            $entityManager->flush();
        }

        return $this->redirectToRoute('gif_index');
    }
}
