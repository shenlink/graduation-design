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
    let title = document.querySelector('#title').innerText;
    let author = document.querySelector('#author').innerText;
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
    request.send("username=" + username + "&article_id=" + article_id + "&title=" + title + "&author=" + author);
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
let editor = new E('#editor-toolbar', '#editor-content');
editor.create();
// 登录后才能评论，评论内容去掉标签，空格后为空的话，不能评论
$('#comment').on('click', function () {
    let content = editor.txt.html();
    let content_text = editor.txt.text();
    let comment = document.querySelector('#comment');
    let username = comment.getAttribute('data-comment');
    let article = document.querySelector('#article');
    let article_id = article.getAttribute('data-article-id');
    let title = document.querySelector('#title').innerText;
    let author = document.querySelector('#author').innerText;
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
    request.open("POST", "/user/addComment");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("content=" + content + "&username=" + username + "&article_id=" + article_id + "&title=" + title + "&author=" + author);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            console.log(request.responseText)
            if (request.responseText == "1") {
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
});

// 删除评论
function delComment(commentId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = commentId;
    let comment_id = temp.getAttribute('data-delComment');
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
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}