<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{

    public function __call($method, $args)
    {
        $view = Factory::createView();
        $article_id = $method;
        if (!is_numeric($article_id)) {
            $view->display('notfound.html');
            exit();
        }
        $article = Factory::createArticle();
        $realArticle_id = $article->checkArticleId($article_id);
        if ($realArticle_id) {
            $category = Factory::createCategory();
            $comment =  Factory::createComment();
            $articles = $article->getArticle($article_id);
            $categorys = $category->getCategory();
            $comments = $comment->getArticleComment($article_id);
            $access = Validate::checkAccess();
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $author = $articles['author'];
            $user = Factory::createUser();
            $follow =  Factory::createFollow();
            $users = $user->personal($author);
            $follows = $follow->getFollow($author);
            foreach ($follows as $values) {
                foreach ($values as $value) {
                    $allFollows .= $value . ',';
                }
            }
            if (in_array($username, explode(',', $allFollows))) {
                $follows = true;
                $view->assign('follows', $follows);
            }
            $view->assign('username', $username);
            $view->assign('articles', $articles);
            $view->assign('categorys', $categorys);
            $view->assign('comments', $comments);
            $view->assign('users', $users);
            $view->display('article.html');
        } else {
            $view->display('notfound.html');
        }
    }
}
