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
    let username = follow.getAttribute('data-username');
    let author = follow.getAttribute('data-author');
    if (username == '') {
        layer.msg('登录才能关注', {
            time: 2000
        });
        return;
    }
    $.post("/follow/checkFollow", {
        author: author,
        username: username
    }, function (data) {
        if (data === '1') {
            layer.msg('关注成功', {
                time: 1000
            }, function () {
                follow.innerText = '已关注';
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
                follow.innerText = '关注';
            });
        }
    });
});


// 发私信
function addMessage() {
    let message = $('#message');
    let author = message.getAttribute('data-author');
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createInput('author', author);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/message/addMessage';
    form.submit();
}


// 分页
function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
    let author = $('#author').getAttribute('data-author');
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
        case 'share':
            input1 = createInput('sharePages', pagination);
            break;
    }
    let input2 = createInput('type', type);
    form.appendChild(input1);
    form.appendChild(input2);
    form.method = 'post';
    form.action = '/user/' + author;
    form.submit();
}