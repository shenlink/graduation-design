// 点赞
$('#praise').on('click', function () {
    let praise = document.querySelector('#praise');
    let username = praise.getAttribute('data-praise');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let author = document.querySelector('#author').innerText;
    let title = document.querySelector('#title').innerText;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/user/checkPraise");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("username=" + username + "&article_id=" + article_id + "&author=" + author + "&title=" + title);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                // 点赞成功，点赞+1，改变点赞字样的颜色
                layer.msg('点赞成功', {
                    time: 1000
                });
            } else {
                layer.msg('已取消点赞', {
                    time: 1000
                });
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
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/user/checkCollect");
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
            } else {
                layer.msg('取消收藏', {
                    time: 1000
                })
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
    let author = document.querySelector('#author').innerText;
    let title = document.querySelector('#title').innerText;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/user/checkShare");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("username=" + username + "&article_id=" + article_id + "&author=" + author + "&title=" + title);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('分享成功', {
                    time: 1000
                });
            } else {
                layer.msg('取消分享', {
                    time: 1000
                })
            }
        }
    }
});


let E = window.wangEditor;
let editor = new E('#editor-toolbar2', '#editor-content2');
editor.create();
// 登录后才能评论，评论内容去掉标签，空格后为空的话，不能评论
$('#comment').on('click', function () {
    let content = editor.txt.html();
    let content_text = editor.txt.text();
    let comment = document.querySelector('#comment');
    let username = comment.getAttribute('data-comment');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let comment_content = document.querySelector('#comment-content');
    let now = new Date();
    let comment_at = now.toLocaleString();
    // 1.创建XMLHttpRequest对象
    if (username == '') {
        layer.msg('登录才能评论', {
            time: 2000
        });
    } else {
        if (content_text.match(/^[ ]+$/) || content_text.length == 0) {
            layer.msg('评论内容不能为空', {
                time: 1000
            });
        } else {
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/user/addComment");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("content=" + content + "&username=" + username + "&article_id=" + article_id + "&comment_at" + comment_at);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    // 插入评论
                    comment_id = request.responseText;
                    let card = document.createElement('div');
                    comment_content.appendChild(card);
                    card.setAttribute('class', 'card');
                    let card_body = document.createElement('div');
                    card.appendChild(card_body);
                    card_body.setAttribute('class', 'card-body');
                    let card_title = document.createElement('h5');
                    card_body.appendChild(card_title);
                    card_title.setAttribute('class', 'card-title');
                    let span_username = document.createElement('span');
                    card_title.appendChild(span_username);
                    span_username.innerText = username;
                    let span_time = document.createElement('span');
                    card_title.appendChild(span_time);
                    let small_time = document.createElement('small');
                    span_time.appendChild(small_time);
                    span_time.setAttribute('class', 'offset-md-1')
                    small_time.innerText = comment_at;
                    let del_div = document.createElement('div');
                    card_title.appendChild(del_div);
                    let small_del = document.createElement('small');
                    del_div.appendChild(small_del);
                    small_del.setAttribute('data-delCommnet', comment_id);
                    small_del.innerHTML = '删除';
                    let card_text = document.createElement('div');
                    card_body.appendChild(card_text);
                    card_text.setAttribute('class', 'card-text');
                    card_text.innerHTML = content;
                    comment_content.insertBefore(card, comment_content.children[0]);
                    layer.msg('评论成功', {
                        time: 1000
                    });
                    window.location.reload();
                } else {
                    layer.msg('评论失败', {
                        time: 1000
                    });
                }
            }
        }
    }
});


// 删除评论
let delComments = document.querySelectorAll('.delComment');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delComments.length; i++) {
    delComments[i].onclick = function () {
        for (let i = 0; i < delComments.length; i++) {
            if (true) {
                let comment_id = this.getAttribute('data-delComment')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/user/delArticleComment");
                // 3.请求头
                request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
                // 4.设置数据
                request.send("comment_id=" + comment_id);
                // 5.监听服务器响应
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        if (request.responseText == "1") {
                            layer.msg('删除成功', {
                                time: 1000
                            });
                            // 不推荐刷新，推荐用removeAttribute
                        } else {
                            layer.msg('删除失败', {
                                time: 1000
                            })
                        }
                    }
                }
            }
        }
    }
}