<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleVoteController extends AbstractController
{
    /**
     * @Route("/articles/{slug}/vote/{type<up|down>}",  name="app_article_vote")
     */
    public function vote(Article $article, $type, LoggerInterface $logger, EntityManagerInterface $em)
    {
        if ($type == 'up') {
            $article->voteUp();
            $logger->info('Up vote');
        } else {
            $article->voteDown();
            $logger->info('Down vote');
        }

        $em->flush();

        return $this->json(['votes' => $article->getVoteCount()]);
    }
}