let lis = document.querySelector('.list-group').querySelectorAll('.list-group-item');
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


// 拉黑用户
let defriendUsers = document.querySelectorAll('.defriendUser');
for (let i = 0; i < defriendUsers.length; i++) {
    defriendUsers[i].onclick = function () {
        for (let i = 0; i < defriendUsers.length; i++) {
            let user_id = this.getAttribute('data-user-id')
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/admin/defriendUser");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("user_id=" + user_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('拉黑成功', {
                            time: 1000
                        })
                        window.location.reload();
                    } else {
                        layer.msg('拉黑失败', {
                            time: 1000
                        })
                    }
                }
            }
        }
    }
}

// 恢复用户到正常状态
let normalUsers = document.querySelectorAll('.normalUser');
for (let i = 0; i < normalUsers.length; i++) {
    normalUsers[i].onclick = function () {
        for (let i = 0; i < normalUsers.length; i++) {
            let user_id = this.getAttribute('data-user-id');
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/admin/normalUser");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("user_id=" + user_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('恢复成功', {
                            time: 1000
                        });
                        window.location.reload();
                    } else {
                        layer.msg('恢复失败', {
                            time: 1000
                        });
                    }
                }
            }

        }
    }
}


// // 删除用户
function delUser(userId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = userId;
    let user_id = temp.getAttribute('data-user-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/admin/delUser");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("user_id=" + user_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                });
                window.location.reload();
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}

// 拉黑文章
let defriendArticles = document.querySelectorAll('.defriendArticle');
for (let i = 0; i < defriendArticles.length; i++) {
    defriendArticles[i].onclick = function () {
        for (let i = 0; i < defriendArticles.length; i++) {
            let article_id = this.getAttribute('data-article-id')
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/admin/defriendArticle");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("article_id=" + article_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('拉黑成功', {
                            time: 1000
                        });
                        window.location.reload();
                    } else {
                        layer.msg('拉黑失败', {
                            time: 1000
                        });
                    }
                }

            }
        }
    }
}

// 恢复文章到正常状态
let normalArticles = document.querySelectorAll('.normalArticle');
for (let i = 0; i < normalArticles.length; i++) {
    normalArticles[i].onclick = function () {
        for (let i = 0; i < normalArticles.length; i++) {
            let article_id = this.getAttribute('data-user-id');
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/admin/normalArticle");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("article_id=" + article_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('恢复成功', {
                            time: 1000
                        });
                        window.location.reload();
                    } else {
                        layer.msg('恢复失败', {
                            time: 1000
                        });
                    }
                }
            }

        }
    }
}


// 删除文章
function delArticle(articleId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = articleId;
    let article_id = temp.getAttribute('data-article-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/admin/delArticle");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                });
                window.location.reload();
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }

}



// 拉黑分类
let defriendcategorys = document.querySelectorAll('.defriendcategory');
for (let i = 0; i < defriendcategorys.length; i++) {
    defriendcategorys[i].onclick = function () {
        for (let i = 0; i < defriendcategorys.length; i++) {
            if (true) {
                let category = this.getAttribute('data-category')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/admin/defriendcategory");
                // 3.请求头
                request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
                // 4.设置数据
                request.send("category=" + category);
                // 5.监听服务器响应
                request.onreadystatechange = function () {
                    if (request.readyState == 4 && request.status == 200) {
                        if (request.responseText == "1") {
                            layer.msg('拉黑成功', {
                                time: 1000
                            });
                            window.location.reload();
                        } else {
                            layer.msg('拉黑失败', {
                                time: 1000
                            });
                        }
                    }
                }
            }
        }
    }
}

// 恢复分类到正常状态
let normalCategorys = document.querySelectorAll('.normalCategory');
for (let i = 0; i < normalCategorys.length; i++) {
    normalCategorys[i].onclick = function () {
        for (let i = 0; i < normalCategorys.length; i++) {
            let category = this.getAttribute('data-category');
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/admin/normalCategory");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("category=" + category);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('恢复成功', {
                            time: 1000
                        });
                        window.location.reload();
                    } else {
                        layer.msg('恢复失败', {
                            time: 1000
                        });
                    }
                }
            }
        }
    }
}

// 删除分类
function delCategory(categoryName) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = categoryName;
    let category = temp.getAttribute('data-category');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/admin/delCategory");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("category=" + category);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                });
                window.location.reload();
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}


// 新增分类
function addCategory() {
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createInput('addCategory', 'addCategory');
    form.appendChild(input);
    form.method = 'post';
    form.action = '/admin/add';
    form.submit();
}

function createInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


// 删除评论
function delComment(commentId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = commentId;
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
    request.open("POST", "/admin/delComment");
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
                window.location.reload();
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }
}



// 删除公告
function delAnnouncement(announcementId) {
    if (!confirm('确认删除吗？')) {
        return;
    }
    let temp = announcementId;
    let announcement_id = temp.getAttribute('data-announcement-id');
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/admin/delAnnouncement");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("announcement_id=" + announcement_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                    time: 1000
                });
                window.location.reload();
            } else {
                layer.msg('删除失败', {
                    time: 1000
                });
            }
        }
    }

}


// 新增公告
function addAnnouncement() {
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createInput('addAnnouncement', 'addAnnouncement');
    form.appendChild(input);
    form.method = 'post';
    form.action = '/admin/add';
    form.submit();
}