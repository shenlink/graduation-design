<?php

namespace core\lib;


use core\lib\Db;

class Pagination extends Db
{
    private $pagination;
    // 单例模式
    private function __construct()
    {
    }
    private function __clone()
    {
    }
    public static function getInstance()
    {
        if (self::$pagination) {
            return self::$pagination;
        } else {
            self::$pagination = new self();
            return self::$pagination;
        }
    }
    // 查询数据总数
    public function count()
    {
        $sql = $this->fixSql('count');
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $total = $stmt->fetchColumn(0);
        return $total;
    }

    // 分页
    // $arr = $table('user)->field('username')->where()->pagination();
    public function pagination($currentPage, $pageSize = 10, $path = '/')
    {
        $count = $this->count();
        $this->limit = ($currentPage - 1) * $pageSize . ',' . $pageSize;
        $data = $this->selectAll();
        $pageHtml = $this->seperatePage($currentPage, $pageSize, $count, $path);
        return array('data' => $data, 'pageHtml' => $pageHtml);
    }

    // 生成分页html(bootstrap风格)；currentPage：当前第几页，pageSize:每页大小，total:数据总数
    private function seperatePage($currentPage, $pageSize, $total, $path)
    {
        // 分页数，向上取整
        $html = '';
        // 56/10
        $pageCount = ceil($total / $pageSize);
        // 生成首页,生成上一页
        if ($currentPage > 1) {
            $html .= "<li class='page-item'><a class='page-link' href='{$path}/page/1'>首页</a></li>";

            $prePage = $currentPage - 1;
            $html .= "<li class='page-item'><a class='page-link' href='{$path}/page/{$prePage}'>上一页</a></li>";
        }

        // 生成数字页
        // 假设分10页，最多显示7页
        $start = $currentPage > ($pageCount - 6) ? ($pageCount - 6) : $currentPage;
        $start = $start - 2;
        $start = $start <= 0 ? 1 : $start;
        $end = ($currentPage + 6) > $pageCount ? $pageCount : ($currentPage + 6);
        $end = $end - 2;
        if ($currentPage + 2 >= $end && $pageCount > 6) {
            $start = $start + 2;
            $end = $end + 2;
        }

        for ($i = $start; $i <= $end; $i++) {
            $html .= $i == $currentPage ? "<li class='page-item active'><a class='page-link'>{$i}</a></li>" : "<li><a class='page-link' href='{$path}/page/{$i}'>{$i}</a></li>";
        }
        // 生成下一页,生成尾页
        if ($currentPage < $pageCount) {
            $nextPage = $currentPage + 1;
            $html .= "<li class='page-item><a class='page-link' href='{$path}/page/{$nextPage}'>下一页</a></li>";
            $html .= "<li class='page-item><a class='page-link' href='{$path}/page/{$pageCount}'>尾页</a></li>";
        }

        $html = '<ul class="pagination justify-content-center">' . $html . '</ul>';
        return $html;
    }
}