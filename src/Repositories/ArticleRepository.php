<?php

namespace src\Repositories;

use src\Models\Article as Article;
use src\Models\User;

class ArticleRepository extends Repository
{

    /**
     * @return Article[]
     */
    public function getAllArticles(): array
    {
        if (!file_exists($this->filename)) {
            return [];
        }
        $fileContents = file_get_contents($this->filename);
        if (!$fileContents) {
            return [];
        }
        $decodedArticles = json_decode($fileContents, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return [];
        }
        $articles = [];
        foreach ($decodedArticles as $decodedArticle) {
            $articleId = time();
            $articles[] = (new Article($articleId))->fill($decodedArticle);
        }
        return $articles;
    }

    /**
     * @param string $title
     * @param string $url
     * @param string $authorId
     * @return Article|false
     */
    public function saveArticle(string $title, string $url, string $authorId): Article|false
    {
        // Generate a unique ID for the new article (e.g., using time())
        $articleId = time();

        // Create a new Article object
        $newArticle = new Article($articleId, $title, $url, $authorId);

        // Get the existing articles
        $articles = $this->getAllArticles();

        // Add the new article to the existing articles array
        $articles[] = $newArticle;

        // Save the updated articles back to the JSON file
        if (file_put_contents($this->filename, json_encode($articles, JSON_PRETTY_PRINT)) === false) {
            return false;
        }

        return $newArticle;
    }

    /**
     * @param int $id
     * @return Article|false Article object if it was found, false otherwise
     */
    public function getArticleById(int $id): Article|false
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $article) {
            if ($article->getId() === $id) {
                return $article;
            }
        }
        return false;
    }

    /**
     * @param int $id
     * @param string $title
     * @param string $url
     * @return bool true on success, false otherwise
     */
    public function updateArticle(int $id, string $title, string $url): bool
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $key => $article) {
            if ($article->getId() === $id) {
                $articles[$key]->setTitle($title);
                $articles[$key]->setUrl($url);

                // Save the updated articles back to the JSON file
                if (file_put_contents($this->filename, json_encode($articles, JSON_PRETTY_PRINT)) === false) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @param int $id
     * @return bool true on success, false otherwise
     */
    public function deleteArticleById(int $id): bool
    {
        $articles = $this->getAllArticles();
        foreach ($articles as $key => $article) {
            if ($article->getId() === $id) {
                unset($articles[$key]);

                // Re-index the array to remove any gaps
                $articles = array_values($articles);

                // Save the updated articles back to the JSON file
                if (file_put_contents($this->filename, json_encode($articles, JSON_PRETTY_PRINT)) === false) {
                    return false;
                }

                return true;
            }
        }

        return false;
    }

   /**
 * @param string $articleId
 * @return User|false
 */
public function getArticleAuthor(string $articleId): User|false
{
    // TODO: Implement logic to get the author of the article

    $sqlStatement = $this->pdo->prepare('
        SELECT users.*
        FROM users
        JOIN articles ON users.id = articles.author_id
        WHERE articles.id = ?
    ');

    $sqlStatement->execute([$articleId]);
    $authorData = $sqlStatement->fetch();

    return $authorData ? new User($authorData['id'], $authorData['name'], $authorData['email'], $authorData['password_digest'], $authorData['profile_picture']) : false;
}

}
