<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use App\Repository\CommentRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post_index", methods={"GET"})
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $page = $request->query->get('page', 1);
        $limit = $this->getParameter('page_limit');
        $offset = ($page - 1) * $limit;
        $paginator = $postRepository->getPostPaginator(Post::Published, $offset, $limit);
        $maxPage = ceil($paginator->count() / $limit);

        return $this->render('post/index.html.twig', [
            'max_page' => $maxPage,
            'paginator' => $paginator,
            'page' => $page,
//            'posts' => $postRepository->findBy(['status' => 2], ['id' => 'desc']),
        ]);
    }


    /**
     * @Route("/post/{identify}", name="post_show", methods={"GET", "POST"})
     * @ParamConverter("post", options={"id" = "identify"})
     */
    public function show(Request $request, Post $post, EntityManagerInterface $entityManager,
        PaginatorInterface $paginator, CommentRepository $commentRepository): Response
    {
        $commentForm = $this->createForm(CommentType::class);

        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            if ($commentForm->get('submit')->isClicked()) {
                /**@var Comment $comment **/
                $comment = $commentForm->getData();
                $comment->setPost($post);
                $comment->setCreatedAt(new \DateTime());
                $entityManager->persist($comment);
                $entityManager->flush();
            }

            $this->addFlash('success', '您的评论已成功提交!');
        }

        $pagination = $paginator->paginate(
            $commentRepository->getPaginatorQuery($post),
            $request->query->getInt('page', 1),
            $this->getParameter('page_limit')
        );

        return $this->render('post/show.html.twig', [
            'post' => $post,
            'pagination' => $pagination,
            'comment_form' => $commentForm->createView()
        ]);
    }

}
