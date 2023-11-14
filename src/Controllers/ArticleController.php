<?php

namespace src\Controllers;

use core\Request;
use src\Repositories\ArticleRepository;
use src\Repositories\UserRepository;
use src\Models\Article;

class ArticleController extends Controller
{
    protected ArticleRepository $articleRepository;
    // protected UserRepository $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        // $this->userRepository = $userRepository;
    }

    /**
     * Display the page showing the articles.
     * @return void
     */
    public function index(): void
    {
        $articles = $this->articleRepository->getAllArticles();
        $this->render('index', ['articles' => $articles]);
    }

    public function about()
    {
        $this->render('about', ['name' => 'Christian']);
    }

    /**
     * Show the form for creating a new article.
     * @return void
     */
    public function create(): void
    {
        $this->render('create');
    }

    /**
     * Process the storing of a new article.
     * @param Request $request
     * @return void
     */
    public function store(Request $request): void
    {
        $title = $request->input('title');
        $url = $request->input('url');
        $authorId = $request->input('author_id'); // Assuming you have a way to determine the author (user) ID.

        $newArticle = $this->articleRepository->saveArticle($title, $url, $authorId);

        if ($newArticle) {
            // Article saved successfully
            $this->redirect('/articles'); // Redirect to the articles index page
        } else {
            // Failed to save article, handle accordingly
            $this->render('create', ['error' => 'Failed to save the article']);
        }
    }

    /**
     * Show the form for editing an article.
     * @param Request $request
     * @return void
     */
    public function edit(Request $request): void
    {
        $articleId = $request->input('id');
        $article = $this->articleRepository->getArticleById($articleId);

        if ($article) {
            $this->render('edit', ['article' => $article]);
        } else {
            // Article not found, handle accordingly
            $this->redirect('/articles'); // Redirect to the articles index page
        }
    }

    /**
     * Process the editing of an article.
     * @param Request $request
     * @return void
     */
    public function update(Request $request): void
    {
        $articleId = $request->input('id');
        $title = $request->input('title');
        $url = $request->input('url');

        $success = $this->articleRepository->updateArticle($articleId, $title, $url);

        if ($success) {
            // Article updated successfully
            $this->redirect('/articles'); // Redirect to the articles index page
        } else {
            // Failed to update article, handle accordingly
            $this->render('edit', ['error' => 'Failed to update the article']);
        }
    }

    /**
     * Process the deleting of an article.
     * @param Request $request
     * @return void
     */
    public function delete(Request $request): void
    {
        $articleId = $request->input('id');
        $success = $this->articleRepository->deleteArticleById($articleId);

        if ($success) {
            // Article deleted successfully
            $this->redirect('/articles'); // Redirect to the articles index page
        } else {
            // Failed to delete article, handle accordingly
            $this->render('index', ['error' => 'Failed to delete the article']);
        }
    }
}
