// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    let searchContent = $('#searchContent').val();
    let form = document.createElement("form");
    document.body.appendChild(form);
    switch (type) {
        case '1':
            input1 = createInput('type', 'user');
            break;
        case '2':
            input1 = createInput('type', 'article');
            break;
    }
    let input2 = createInput('content', searchContent);
    form.appendChild(input1);
    form.appendChild(input2);
    form.method = 'post';
    if (type == '1') {
        form.action = '/user/search';
    } else {
        form.action = '/article/search';
    }
    form.submit();
});


function createInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


// 左边的导航切换
let lis = $('.list-group-item');
let items = $('.manage-item');
// for循环在页面加载完成之后就已经执行完了，这时候lis的index索引已经赋值完成,然后执行lis[i].click事件注册，待点击之后就触发
for (let i = 0; i < lis.length; i++) {
    lis[i].setAttribute('data-index', i);
    lis[i].onclick = function () {
        for (let i = 0; i < lis.length; i++) {
            lis[i].className = 'list-group-item';
        }
        this.className = 'list-group-item current';
        let index = this.getAttribute('data-index');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = 'none';
        }
        items[index].style.display = 'block';
    }
}


// 编辑文章
function editArticle(articleId) {
    let temp = articleId;
    let article_id = temp.getAttribute('data-article-id');
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createInput('article_id', article_id);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/article/editArticle';
    form.submit();
}


// 删除文章
function delArticle(articleId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = articleId;
    let article_id = temp.getAttribute('data-article-id');
    let category = temp.getAttribute('data-category');
    $.post("/article/delArticle", {
        article_id: article_id,
        category: category
    }, function (data) {
        if (data === '1') {
            layer.msg('删除成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                let tbody = tr.parentNode;
                tbody.removeChild(tr);
            });
        } else {
            layer.msg('删除失败', {
                time: 1000
            });
        }
    });
}


// 删除评论
function delComment(commentId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = commentId;
    let article_id = temp.getAttribute('data-article-id');
    let comment_id = temp.getAttribute('data-comment-id');
    $.post("/comment/delComment", {
        article_id: article_id,
        comment_id: comment_id
    }, function (data) {
        if (data === '1') {
            layer.msg('删除成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                let tbody = tr.parentNode;
                tbody.removeChild(tr);
            });
        } else {
            layer.msg('删除失败', {
                time: 1000
            });
        }
    });
}


// 取消关注
function delFollow(followName) {
    let temp = followName;
    let username = temp.getAttribute('data-username');
    let author = temp.getAttribute('data-author');
    $.post("/follow/delFollow", {
        author: author,
        username: username
    }, function (data) {
        if (data === '1') {
            layer.msg('取消关注', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                let tbody = tr.parentNode;
                tbody.removeChild(tr);
            });
        } else {
            layer.msg('取消关注失败', {
                time: 1000
            });
        }
    });
}


// 删除私信
function delReceive(receiveId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = receiveId;
    let receive_id = temp.getAttribute('data-receive-id');
    $.post("/receive/delReceive", {
        receive_id: receive_id
    }, function (data) {
        if (data === '1') {
            layer.msg('删除成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                let tbody = tr.parentNode;
                tbody.removeChild(tr);
            });
        } else {
            layer.msg('删除失败', {
                time: 1000
            });
        }
    });
}


// 分页
function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
    let type = temp.getAttribute('data-type');
    if (pagination == 'current_1') {
        layer.msg('已经是第一页了', {
            time: 1000
        });
        return;
    }
    if (pagination == 'current_end') {
        layer.msg('已经是末页了', {
            time: 1000
        });
        return;
    }
    let form = document.createElement("form");
    document.body.appendChild(form);
    switch (type) {
        case 'article':
            input1 = createInput('articlePages', pagination);
            break;
        case 'comment':
            input1 = createInput('commentPages', pagination);
            break;
        case 'follow':
            input1 = createInput('followPages', pagination);
            break;
        case 'fans':
            input1 = createInput('fansPages', pagination);
            break;
        case 'receive':
            input1 = createInput('receivePages', pagination);
            break;
    }
    let input2 = createInput('type', type);
    form.appendChild(input1);
    form.appendChild(input2);
    form.method = 'post';
    form.action = '/user/manage';
    form.submit();
}