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
// let check = confirm('确认删除吗？');
for (let i = 0; i < defriendUsers.length; i++) {
    defriendUsers[i].onclick = function () {
        for (let i = 0; i < defriendUsers.length; i++) {
            if (true) {
                let user_id = this.getAttribute('data-defriendUser')
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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
}


// 删除用户
let delUsers = document.querySelectorAll('.delUser');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delUsers.length; i++) {
    delUsers[i].onclick = function () {
        for (let i = 0; i < delUsers.length; i++) {
            if (true) {
                let user_id = this.getAttribute('data-delUsers')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/admin/delUsers");
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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
}







// 拉黑文章
let defriendArticles = document.querySelectorAll('.defriendArticle');
// let check = confirm('确认删除吗？');
for (let i = 0; i < defriendArticles.length; i++) {
    defriendArticles[i].onclick = function () {
        for (let i = 0; i < defriendArticles.length; i++) {
            if (true) {
                let article_id = this.getAttribute('data-defriendArticle')
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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
}


// 删除文章
let delArticles = document.querySelectorAll('.delArticle');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delArticles.length; i++) {
    delArticles[i].onclick = function () {
        for (let i = 0; i < delArticles.length; i++) {
            if (true) {
                let article_id = this.getAttribute('data-delArticles')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/admin/delArticles");
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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
}



// 删除分类
let delCategorys = document.querySelectorAll('.delCategory');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delCategorys.length; i++) {
    delCategorys[i].onclick = function () {
        for (let i = 0; i < delCategorys.length; i++) {
            if (true) {
                let article_id = this.getAttribute('data-delCategorys')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/admin/delCategorys");
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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
}


// 删除评论
let delComments = document.querySelectorAll('.delComment');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delComments.length; i++) {
    delComments[i].onclick = function () {
        for (let i = 0; i < delComments.length; i++) {
            if (true) {
                let comment_id = this.getAttribute('data-del')
                // 1.创建XMLHttpRequest对象
                let request = null;
                if (XMLHttpRequest) {
                    request = new XMLHttpRequest();
                } else {
                    //兼容老IE浏览器
                    request = new ActiveXObject("Msxml2.XMLHTTP");
                }
                // 2.请求行
                request.open("POST", "/user/delComment");
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
                            }, function (index, layero) {
                                window.location.reload();
                                layero.close(index);
                            });

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



