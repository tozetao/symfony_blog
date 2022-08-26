<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Post;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class CommentController extends AbstractController
{
    /**
     * @Route("/post/{post_id}/comment/{comment_id}/reply", name="reply_comment", options={"expose"=true})
     * @ParamConverter("post", options={"id" = "post_id"})
     * @ParamConverter("parentComment", options={"id" = "comment_id"})
     */
    public function replyComment(Request $request, Post $post, Comment $parentComment): Response
    {
        $replyComment = $this->createForm(CommentType::class, null, [
            'action' => $request->getUri()
        ]);

        return $this->render('comment/_reply_comment_form.html.twig', [
            'reply_comment_form' => $replyComment->createView()
        ]);
    }
}
