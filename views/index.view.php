<?php
require_once 'header.php'
?>

<body>

    <?php require_once 'nav.php' ?>

    <div class="mx-auto max-w-4xl sm:px-6 lg:px-8">

        <h1 class="text-xl text-center font-semibold text-indigo-500 mt-10 mb-10 title">Articles</h1>

        <h6 class="text-center"><?= count($articles) === 0 ? "No articles yet :(" : ""; ?></span>

            <div class="sm:rounded-md">
                <ul role="list" class="mb-20">
                    <?php foreach ($articles as $article) : ?>
                        <div class="articles">
                    <a href='<?= $article->getUrl(); ?>'>
                        <div class="articles_list">
                            <?= $article->getTitle(); ?>
                            <div class="article-icons">
                                <a href="update_article.php?id=<?= $article->getId(); ?>" class="article-icon">
                                    <!-- <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> -->
                                    <span class="material-symbols-outlined">edit</span>
                                </a>
                                <a href="delete_article.php?id=<?= $article->getId(); ?>" class="article-icon">
                                    <!-- <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> -->
                                    <span class="material-symbols-outlined">delete_forever</span>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
                    <?php endforeach; ?>

                </ul>
            </div>

    </div>

</body>