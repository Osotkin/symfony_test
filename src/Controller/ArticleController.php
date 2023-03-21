<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(ArticleRepository $repository, CommentRepository $commentRepository, Request $request)
    {
        $articles = $repository->findLatestPublished();
        $comments = $commentRepository->findLastThreeComments();
        return $this->render('articles/homepage.html.twig', [
            'articles' => $articles,
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/articles/{slug}", name="app_article_show")
     */
    public function show(Article $article)
    {
        if ($article->getVoteCount() > 0) {
            $voteText = 'text-success';
        } elseif ($article->getVoteCount() == 0) {
            $voteText = 'text-secondary';
        } else {
            $voteText ='text-danger';
        }

        return $this->render('articles/show.html.twig', [
            'article' => $article,
                'voteText' => $voteText,
            ]
        );
    }
}