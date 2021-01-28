<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Movie;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/film/{id}", name="movie")
     */
    public function index(Request $request, $id): Response
    {
        $movie = $this->entityManager->getRepository(Movie::class)->findOneById($id);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() AND $form->isValid()){
            $comment = $form->getData();
            $comment->setMovieId($id);
            $comment->setCreatedAt(new \DateTime("now"));

            $this->entityManager->persist($comment);
            $this->entityManager->flush();
            $this->addFlash(
                'success',
                'Votre commentaire a été enregistré !'
            );
            return $this->redirectToRoute('movie', ['id' => $id]);
        }

        $comments = $this->entityManager->getRepository(Comment::class)->findBy(['movie_id' => $id]);


        return $this->render('movie/index.html.twig', [
            'movie' => $movie,
            'comments' => $comments,
            'form' => $form->createView()
        ]);
    }
}
