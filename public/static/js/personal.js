let lis = document.querySelector('.manage-ul').querySelectorAll('.manage-list');
let items = document.querySelectorAll('.manage-item');
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
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/comment/delComment");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id +
        "&comment_id=" + comment_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                });
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}


// 删除点赞,还有article_id
function delPraise(praiseId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = praiseId;
    let article_id = temp.getAttribute('data-article-id');
    let praise_id = temp.getAttribute('data-praise-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/praise/delPraise");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id +
        "&praise_id=" + praise_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 2000
                }, function () {
                    window.location.reload();
                })
            } else {
                layer.msg('删除失败', {
                    time: 1000
                })
            }
        }
    }
}

// 删除收藏
function delCollect(collectId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = collectId;
    let article_id = temp.getAttribute('data-article-id');
    let collect_id = temp.getAttribute('data-collect-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/collect/delCollect");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id +
        "&collect_id=" + collect_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                })
            } else {
                layer.msg('删除失败', {
                    time: 1000
                })
            }
        }
    }
}




// 删除分享
function delShare(shareId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = shareId;
    let article_id = temp.getAttribute('data-article-id');
    let share_id = temp.getAttribute('data-share-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/share/delShare");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id +
        "&share_id=" + share_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                })
            } else {
                layer.msg('删除失败', {
                    time: 1000
                })
            }
        }
    }
}


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
            input1 = createPageInput('articlePages', pagination);
            break;
        case 'comment':
            input1 = createPageInput('commentPages', pagination);
            break;
        case 'praise':
            input1 = createPageInput('praisePages', pagination);
            break;
        case 'collect':
            input1 = createPageInput('collectPages', pagination);
            break;
        case 'share':
            input1 = createPageInput('sharePages', pagination);
            break;
    }
    let input2 = createPageInput('type', type);
    form.appendChild(input1);
    form.appendChild(input2);
    form.method = 'post';
    form.action = '/user/personal';
    form.submit();
}


function createPageInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}