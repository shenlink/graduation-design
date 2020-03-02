<?php

namespace app\controller;

use app\model\Comment;
use core\lib\Controller;
use core\lib\Factory;

class Article extends Controller
{

    // 当用户在URL中输入/article/之后的是数字时调用该方法
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
            $articles = $article->getArticle($article_id);
            $comment =  Factory::createComment();
            $comments = $comment->getArticleComment($article_id);
            $category = Factory::createCategory();
            $categorys = $category->getCategory();
            $access = Validate::checkAccess();
            if ($access == 1 || $access == 2) {
                $username = $_SESSION['username'];
            }
            $author = $articles['author'];
            $user = Factory::createUser();
            $users = $user->personal($author);
            $follow =  Factory::createFollow();
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
            $view->assign('comments', $comments);
            $view->assign('username', $username);
            $view->assign('users', $users);
            $view->assign('categorys', $categorys);
            $view->assign('articles', $articles);
            $view->display('article.html');
        } else {
            $view->display('notfound.html');
        }
    }
}
