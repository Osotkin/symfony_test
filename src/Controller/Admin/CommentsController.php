<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use Carbon\Carbon;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 *@IsGranted("ROLE_ADMIN_COMMENT")
 */
class CommentsController extends AbstractController
{
    //#[Route('/admin/comments', name: 'app_admin_comments')]
    /**
     * @Route("/admin/comments", name="app_admin_comments")
     */
    public function index(Request $request, CommentRepository $commentRepository, PaginatorInterface $paginator): Response
    {

        $pagination = $paginator->paginate(
            $commentRepository->findAllWithSearchQuery(
                $request->query->get('q'),
                $request->query->has('showDeleted'),
            ),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/comments/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
