<?php

declare(strict_types=1);

namespace App\Presentation\Http\App\Controller\Article;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Application\Service\ArticleService;

class ArticleController extends AbstractController
{
    #[Route(path: '/article/list', name: 'app_article_list', methods: ['GET'])]
    public function list(ArticleService $articleService): Response
    {
        return $this->render('app/page/article/list.html.twig',
            [
                'articles' => $articleService->getListArticles()
            ]);
    }

    #[Route(path: '/article/show/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show($id, ArticleService $articleService): Response
    {
        return $this->render('app/page/article/show.html.twig', $articleService->getShowArticle($id));
    }

    #[Route(path: '/article/delete/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete($id, ArticleService $articleService): Response
    {
        $articleService->deleteArticle($id);

        return $this->redirectToRoute("app_article_list");
    }

    #[Route(path: '/article/create', name: 'app_article_create', methods: ['GET','POST'])]
    public function create(ArticleService $articleService): Response
    {
        $articleService->createArticle();
        return $this->redirectToRoute("app_article_list");
    }

}
