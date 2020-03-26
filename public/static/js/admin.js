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

// 左边的导航栏切换
let lis = $('.list-group-item');
let items = document.querySelectorAll('.manage-item');
// for循环在页面加载完成之后就已经执行完了，这时候lis的index索引已经赋值完成,然后执行lis[i].click事件注册，待点击之后就触发
for (let i = 0; i < lis.length; i++) {
    lis[i].setAttribute('index', i);
    lis[i].onclick = function () {
        for (let i = 0; i < lis.length; i++) {
            lis[i].className = 'list-group-item';
        }
        this.className = 'list-group-item current';
        let index = this.getAttribute('index');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = 'none';
        }
        items[index].style.display = 'block';
    }
}

function createHtml(function1, function2, data, value, action) {
    let html = `<button class="btn btn-primary btn-sm" onclick="${function1}(this)" data-${data}=${value}>
        ${action}
    </button>
    <button class="btn btn-primary btn-sm" onclick="${function2}(this)" data-${data}=${value}>
        删除
    </button>`;
    return html;
}

// 拉黑用户
function defriendUser(userId) {
    let temp = userId;
    let user_id = temp.getAttribute('data-user-id');
    if (user_id == "1") {
        alert('这是管理员，不能拉黑');
        return;
    }
    $.post("/user/defriendUser", {
        user_id: user_id
    }, function (data) {
        if (data === '1') {
            layer.msg('拉黑成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[8].innerText = '拉黑';
                let html = createHtml('normalUser', 'delUser', 'user-id', user_id, '恢复');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('拉黑失败', {
                time: 1000
            });
        }
    });
}

// 恢复用户到正常状态
function normalUser(userId) {
    let temp = userId;
    let user_id = temp.getAttribute('data-user-id');
    $.post("/user/normalUser", {
        user_id: user_id
    }, function (data) {
        if (data === '1') {
            layer.msg('恢复成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[8].innerText = '正常';
                let html = createHtml('defriendUser', 'delUser', 'user-id', user_id, '拉黑');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('恢复失败', {
                time: 1000
            });
        }
    });
}

// // 删除用户
function delUser(userId) {
    let temp = userId;
    let user_id = temp.getAttribute('data-user-id');
    if (user_id == "1") {
        alert('这是管理员，不能删除');
        return;
    }
    if (!confirm('确认删除吗？')) {
        return;
    }
    $.post("/user/delUser", {
        user_id: user_id
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

// 拉黑文章
function defriendArticle(articleId) {
    let temp = articleId;
    let article_id = temp.getAttribute('data-article-id');
    $.post("/article/defriendArticle", {
        article_id: article_id
    }, function (data) {
        if (data === '1') {
            layer.msg('拉黑成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[3].innerText = '拉黑';
                let html = createHtml('normalArticle', 'delArticle', 'article-id', article_id, '恢复');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('拉黑失败', {
                time: 1000
            });
        }
    });
}

// 恢复文章到正常状态
function normalArticle(articleId) {
    let temp = articleId;
    let article_id = temp.getAttribute('data-article-id');
    $.post("/article/normalArticle", {
        article_id: article_id
    }, function (data) {
        if (data === '1') {
            layer.msg('恢复成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[3].innerText = '正常';
                let html = createHtml('defriendArticle', 'delArticle', 'article-id', article_id, '拉黑');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('恢复失败', {
                time: 1000
            });
        }
    });
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

// 拉黑分类
function defriendCategory(categoryName) {
    let temp = categoryName;
    let category = temp.getAttribute('data-category');
    $.post("/category/defriendCategory", {
        category: category
    }, function (data) {
        if (data === '1') {
            layer.msg('拉黑成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[2].innerText = '拉黑';
                let html = createHtml('normalCategory', 'delCategory', 'category', category, '恢复');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('拉黑失败', {
                time: 1000
            });
        }
    });
}

// 恢复分类到正常状态
function normalCategory(categoryName) {
    let temp = categoryName;
    let category = temp.getAttribute('data-category');
    $.post("/category/normalCategory", {
        category: category
    }, function (data) {
        if (data === '1') {
            layer.msg('恢复成功', {
                time: 1000
            }, function () {
                let tr = temp.parentNode.parentNode;
                tr.children[2].innerText = '正常';
                let html = createHtml('defriendCategory', 'delCategory', 'category', category, '拉黑');
                tr.lastElementChild.innerHTML = html;
            });
        } else {
            layer.msg('恢复失败', {
                time: 1000
            });
        }
    });
}

// 删除分类
function delCategory(categoryName) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = categoryName;
    let category = temp.getAttribute('data-category');
    $.post("/category/delCategory", {
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

// 新增分类
function addCategory() {
    window.location.href = '/category/addCategory';
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

// 删除公告
function delAnnouncement(announcementId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = announcementId;
    let announcement_id = temp.getAttribute('data-announcement-id');
    $.post("/announcement/delAnnouncement", {
        announcement_id: announcement_id
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

// 新增公告
function addAnnouncement() {
    window.location.href = '/announcement/addAnnouncement';
}


// 发私信
function addMessage() {
    let author = $('#addMessage').data('author');
    window.location.href = '/message/addMessage/username/' + author;
}

// 删除私信
function delMesssage(messageId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = messageId;
    let message_id = temp.getAttribute('data-message-id');
    $.post("/message/delMessage", {
        message_id: message_id
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
    switch (type) {
        case 'user':
            pagination = $(`#userJump`).val();
            break;
        case 'article':
            pagination = $(`#articleJump`).val();
            break;
        case 'category':
            pagination = $(`#categoryJump`).val();
            break;
        case 'comment':
            pagination = $(`#commentJump`).val();
            break;
        case 'announcement':
            pagination = $(`#announcementJump`).val();
            break;
        case 'message':
            pagination = $(`#messageJump`).val();
            break;
    }
    window.location.href = `/admin/manage/${type}/${pagination}`;
}