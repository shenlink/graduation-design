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

let lis = $('.manage-list');
let items = $('.manage-item');
// for循环在页面加载完成之后就已经执行完了，这时候lis的index索引已经赋值完成,然后执行lis[i].click事件注册，待点击之后就触发
for (let i = 0; i < lis.length; i++) {
    lis[i].setAttribute('index', i);
    lis[i].onclick = function () {
        for (let i = 0; i < lis.length; i++) {
            lis[i].className = 'h4 manage-list';
        }
        this.className = 'h4 manage-list current';
        let index = this.getAttribute('index');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = 'none';
        }
        items[index].style.display = 'block';
    }
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
                let tr1 = temp.parentNode.parentNode;
                let tr2 = tr1.nextElementSibling;
                let table = tr1.parentNode;
                table.removeChild(tr1);
                table.removeChild(tr2);
            });
        } else {
            layer.msg('删除失败', {
                time: 1000
            });
        }
    });
}

// 删除点赞
function delPraise(praiseId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = praiseId;
    let article_id = temp.getAttribute('data-article-id');
    let praise_id = temp.getAttribute('data-praise-id');
    $.post("/praise/delPraise", {
        article_id: article_id,
        praise_id: praise_id
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

// 删除收藏
function delCollect(collectId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = collectId;
    let article_id = temp.getAttribute('data-article-id');
    let collect_id = temp.getAttribute('data-collect-id');
    $.post("/collect/delCollect", {
        article_id: article_id,
        collect_id: collect_id
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

// 删除分享
function delShare(shareId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = shareId;
    let article_id = temp.getAttribute('data-article-id');
    let share_id = temp.getAttribute('data-share-id');
    $.post("/share/delShare", {
        article_id: article_id,
        share_id: share_id
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

// 关注或取消关注
$('#follow').on('click', function () {
    let follow = $('#follow');
    let username = follow.data('username');
    let author = follow.data('author');
    if (username == '') {
        layer.msg('登录才能关注', {
            time: 2000
        });
        return;
    }
    $.post("/follow/checkFollow", {
        author: author
    }, function (data) {
        if (data === '1') {
            layer.msg('关注成功', {
                time: 1000
            }, function () {
                follow.text('已关注');
            });
        } else if (data === '11') {
            layer.msg('关注失败', {
                time: 1000
            });
        } else if (data === '00') {
            layer.msg('取消失败', {
                time: 1000
            });
        } else {
            layer.msg('取消关注', {
                time: 1000
            }, function () {
                follow.text('关注');
            });
        }
    });
});

// 发私信
function addMessage() {
    let author = $('#addMessage').data('author');
    window.location.href = '/message/addMessage/username/' + author;
}

// 分页
function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
    if (pagination == 'current_1') {
        layer.msg('已经是第一页了', {
            time: 1000
        });
        return;
    }
    if (pagination == 'current_page') {
        layer.msg('已经是当前页了', {
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
}

// 页数跳转
function jumpPage(pages) {
    let temp = pages;
    let type = temp.getAttribute('data-type');
    let author = $('#author').data('author');
    let count = temp.getAttribute('data-count');
    let current_page = $('#current').data('pagination');
    switch (type) {
        case 'article':
            pagination = $(`#articleJump`).val();
            break;
        case 'comment':
            pagination = $(`#commentJump`).val();
            break;
        case 'praise':
            pagination = $(`#praiseJump`).val();
            break;
        case 'collect':
            pagination = $(`#collectJump`).val();
            break;
        case 'share':
            pagination = $(`#shareJump`).val();
            break;
    }
    if (parseInt(pagination) > parseInt(count)) {
        layer.msg('输入页数太大了', {
            time: 1000
        });
        return;
    }
    if (parseInt(current_page) == parseInt(pagination)) {
        layer.msg('已经是跳转页了', {
            time: 1000
        });
        return;
    }
    window.location.href = `/user/${author}/${type}/${pagination}`;
}