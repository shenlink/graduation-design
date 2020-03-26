// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    let searchContent = $('#searchContent').val();
    if (searchContent == '') {
        layer.msg('查询条件不能为空', {
            time: 1000
        });
        return;
    }
    if (type == '1') {
        window.location.href = '/user/search/username/' + searchContent;
    } else {
        window.location.href = '/article/search/condition/' + searchContent;
    }
});

// 编辑文章
$('#edit').on('click', function () {
    let title = $('#title').val();
    let content = editor.txt.html();
    let category = $('#category').val();
    let content_text = editor.txt.text();
    if (title.match(/^[ ]+$/) || title.length == 0) {
        layer.msg('标题不能为空', {
            time: 1000
        });
        return;
    }
    if (content_text.match(/^[ ]+$/) || content_text.length == 0) {
        layer.msg('文章内容不能为空', {
            time: 1000
        });
        return;
    }
    let article_id = this.getAttribute('data-editArticle');
    $.post("/article/checkEdit", {
        article_id: article_id,
        title: title,
        content: content,
        category: category
    }, function (data) {
        if (data === '1') {
            layer.msg('更改成功', {
                time: 1000
            }, function () {
                location.href = '/user/manage';
            });
        } else {
            layer.msg('更改失败', {
                time: 1000
            });
        }
    });
});