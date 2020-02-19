<?php

namespace app\controller;

use core\lib\Controller;
use core\lib\Factory;

class Post extends Controller
{
    public function __call($method, $args)
    {
        $view = Factory::createView();
        if (is_numeric($method)) {
            $article_id = $method;
            $post = new \app\model\Post();
            $data = $post->getArticle($article_id);
            if ($data) {
                $category = $data['category_id'];
                switch($category){
                    case "1":
                        $category = 'php';
                    break;
                    case "2":
                        $category = 'mysql';
                        break;
                    case "3":
                        $category = 'javaScript';
                        break;
                    case "4":
                        $category = 'html';
                        break;
                    case "5":
                        $category = 'python';
                        break;
                    case "6":
                        $category = 'java';
                        break;
                    case "7":
                        $category = '计算机基础';
                        break;

                }
                $view->assign('category',$category);
                $view->assign('data', $data);
                $view->display('article.html');
            } else {
                $view->display('notfound.httml');
            }
        } else {
            $view->display('notfound.httml');
        }
    }
}
