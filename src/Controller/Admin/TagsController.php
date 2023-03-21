<?php

namespace App\Controller\Admin;

use App\Repository\CommentRepository;
use App\Repository\TagRepository;
use Carbon\Carbon;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN_TAG")
 */
class TagsController extends AbstractController
{
    #[Route('/admin/tags', name: 'app_admin_tags')]
    public function index(Request $request, TagRepository $tagRepository, PaginatorInterface $paginator): Response
    {

        $pagination = $paginator->paginate(
            $tagRepository->findAllWithSearchQuery(
                $request->query->get('q'),
                $request->query->has('showDeleted'),
            ),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/tags/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
