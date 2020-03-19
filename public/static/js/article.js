// 搜索
$('#search').on('click', function () {
    let type = document.querySelector('#type').value;
    let searchContent = document.querySelector('#searchContent').value;
    let form = document.createElement("form");
    document.body.appendChild(form);
    switch (type) {
        case '1':
            input1 = createSearchInput('type', 'user');
            break;
        case '2':
            input1 = createSearchInput('type', 'article');
            break;
    }
    let input2 = createSearchInput('content', searchContent);
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

function createSearchInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


// 点赞
$('#praise').on('click', function () {
    let praise = document.querySelector('#praise');
    let username = praise.getAttribute('data-praise');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let author = document.querySelector('#author').innerText;
    let title = document.querySelector('#title').innerText;
    let praise_count = parseInt(praise.innerText.replace(/[^0-9]/ig, ""));
    if (username == '') {
        layer.msg('请先登录', {
            time: 1000
        });
        return;
    }
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/praise/checkPraise");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("username=" + username + "&article_id=" + article_id + "&author=" + author + "&title=" + title);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('点赞成功', {
                    time: 1000
                });
                praise.innerHTML = `已点赞(${praise_count+1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            } else {
                layer.msg('取消点赞', {
                    time: 1000
                });
                praise.innerHTML = `点赞(${praise_count-1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            }
        }
    }
});


// 收藏
$('#collect').on('click', function () {
    let collect = document.querySelector('#collect');
    let username = collect.getAttribute('data-collect');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let author = document.querySelector('#author').innerText;
    let title = document.querySelector('#title').innerText;
    let collect_count = parseInt(collect.innerText.replace(/[^0-9]/ig, ""));
    if (username == '') {
        layer.msg('请先登录', {
            time: 1000
        });
        return;
    }
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/collect/checkCollect");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("username=" + username + "&article_id=" + article_id + "&author=" + author + "&title=" + title);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('收藏成功', {
                    time: 1000
                });
                collect.innerHTML = `已收藏(${collect_count+1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            } else {
                layer.msg('取消收藏', {
                    time: 1000
                });
                collect.innerHTML = `收藏(${collect_count-1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            }
        }
    }
});

// 分享
$('#share').on('click', function () {
    let share = document.querySelector('#share');
    let username = share.getAttribute('data-share');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let title = document.querySelector('#title').innerText;
    let author = document.querySelector('#author').innerText;
    let share_count = parseInt(share.innerText.replace(/[^0-9]/ig, ""));
    if (username == '') {
        layer.msg('请先登录', {
            time: 1000
        });
        return;
    }
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/share/checkShare");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("username=" + username + "&article_id=" + article_id + "&title=" + title + "&author=" + author);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('分享成功', {
                    time: 1000
                });
                share.innerHTML = `已分享(${share_count+1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            } else {
                layer.msg('取消分享', {
                    time: 1000
                });
                share.innerHTML = `分享(${share_count-1})&nbsp;&nbsp;&nbsp;&nbsp;`;
            }
        }
    }
});

function createTime() {
    let date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth();
    let day = date.getDate();
    let hour = date.getHours();
    let minute = date.getMinutes();
    let second = date.getSeconds();
    if (parseInt(month) < 10) {
        month = (parseInt(month) + 1).toString();
        month = '0' + month;
    }
    if (parseInt(day) < 10) {
        day = '0' + day;
    }
    if (parseInt(hour) < 10) {
        hour = '0' + hour;
    }
    if (parseInt(minute) < 10) {
        minute = '0' + minute;
    }
    if (parseInt(second) < 10) {
        second = '0' + second;
    }
    let RecentTime = `${year}-${month}-${day} ${hour}:${minute}:${second}`;
    return RecentTime;
}

function createComment(username, comment_at, comment_id, content) {
    let comment_html = `<div class="card-body">
                                    <h5 class="card-title">
                                        <span>${username}</span>
                                        <span>
                                            <small class="offset-md-1">
                                                ${comment_at}
                                            </small>
                                        </span>
                                        <div>
                                            <small class="delComment"
                                                onclick="delComment(this)"
                                                data-comment-id=
                                                ${comment_id}>删除
                                            </small>
                                        </div>
                                    </h5>
                                    <div class="card-text">
                                        ${content}
                                    </div>
                                </div>`;
    let div = document.createElement("div");
    div.setAttribute('class', 'card');
    div.innerHTML = comment_html;
    return div;
}

let E = window.wangEditor;
let editor = new E('#editor-toolbar', '#editor-content');
editor.create();
// 登录后才能评论，评论内容去掉标签，空格后为空的话，不能评论
$('#comment').on('click', function () {
    let html = editor.txt.html();
    let content = filterXSS(html);
    let content_text = editor.txt.text();
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let author = document.querySelector('#author').getAttribute('data-author');
    let title = document.querySelector('#title').innerText;
    let comment = document.querySelector('#comment');
    let username = comment.getAttribute('data-comment');
    let commentContent = document.querySelector('#comment-content');
    let count = document.querySelector('#comment-count');
    let comment_count = parseInt(count.innerText.replace(/[^0-9]/ig, ""));
    let comment_at = createTime();
    // 1.创建XMLHttpRequest对象
    if (username == '') {
        layer.msg('登录才能评论', {
            time: 2000
        });
        return;
    }
    if (content_text.match(/^[ ]+$/) || content_text.length == 0) {
        layer.msg('评论内容不能为空', {
            time: 1000
        });
        return;
    }
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/comment/addComment");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id + "&author=" + author + "&title=" + title + "&content=" + content + "&username=" + username);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText != "0") {
                layer.msg('评论成功', {
                    time: 1000
                }, function () {
                    comment_id = request.responseText;
                    let div = createComment(username, comment_at, comment_id, content);
                    commentContent.insertBefore(div, commentContent.children[0]);
                    count.innerHTML = `评论数：${comment_count + 1}`;
                    editor.txt.html('');
                });
            } else {
                layer.msg('评论失败', {
                    time: 1000
                });
            }
        }
    }
});

// 删除评论
function delComment(commentId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = commentId;
    let comment_id = temp.getAttribute('data-comment-id');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let count = document.querySelector('#comment-count');
    let comment_count = parseInt(count.innerText.replace(/[^0-9]/ig, ""));
    let commentContent = document.querySelector('#comment-content');
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
    request.send("comment_id=" + comment_id + "&article_id=" + article_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                }, function () {
                    let card = temp.parentNode.parentNode.parentNode.parentNode;
                    commentContent.removeChild(card);
                    count.innerHTML = `评论数：${comment_count-1}`;
                });
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}

$('#follow').on('click', function () {
    let follow = document.querySelector('#follow');
    let username = follow.getAttribute('data-username');
    let author = follow.getAttribute('data-author');
    if (username == '') {
        layer.msg('登录才能关注', {
            time: 2000
        });
        return;
    }
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/follow/checkFollow");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("author=" + author + "&username=" + username);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('关注成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                });
            } else {
                layer.msg('取消关注成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                });
            }
        }
    }
});

function addMessage() {
    let message = document.querySelector('#message');
    let author = message.getAttribute('data-author');
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createMessageInput('author', author);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/message/addMessage';
    form.submit();
}

function createMessageInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}