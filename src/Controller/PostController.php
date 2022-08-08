<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="app_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findBy(['status' => 2], ['id' => 'desc']),
        ]);
    }


    /**
     * @Route("/post/{identify}", name="app_post_show", methods={"GET", "POST"})
     * @ParamConverter("post", options={"id" = "identify"})
     */
    public function show(Request $request, Post $post, EntityManagerInterface $entityManager): Response
    {
        $commentForm = $this->createForm(CommentType::class);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if ($commentForm->get('submit')->isClicked()) {
                /**@var Comment $data **/
                $data = $commentForm->getData();
                $data->setPost($post);
                $entityManager->persist($data);
                $entityManager->flush();
            }
        }

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'comment_form' => $commentForm->createView()
        ]);
    }

}
