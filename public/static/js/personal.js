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


// 删除收藏
let delCollects = document.querySelectorAll('.delCollect');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delCollects.length; i++) {
    delCollects[i].onclick = function () {
        for (let i = 0; i < delCollects.length; i++) {
            let collect_id = this.getAttribute('data-collect-id')
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/user/delCollect");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("collect_id=" + collect_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('删除成功', {
                            time: 1000
                        })
                        window.location.reload();
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




// 删除分享
let delShares = document.querySelectorAll('.delShare');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delShares.length; i++) {
    delShares[i].onclick = function () {
        for (let i = 0; i < delShares.length; i++) {
            let share_id = this.getAttribute('data-share-id')
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/user/delShare");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("share_id=" + share_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('删除成功', {
                            time: 1000
                        })
                        window.location.reload();
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


// 删除点赞
let delPraises = document.querySelectorAll('.delPraise');
// let check = confirm('确认删除吗？');
for (let i = 0; i < delPraises.length; i++) {
    delPraises[i].onclick = function () {
        for (let i = 0; i < delPraises.length; i++) {
            let praise_id = this.getAttribute('data-praise-id');
            // 1.创建XMLHttpRequest对象
            let request = null;
            if (XMLHttpRequest) {
                request = new XMLHttpRequest();
            } else {
                //兼容老IE浏览器
                request = new ActiveXObject("Msxml2.XMLHTTP");
            }
            // 2.请求行
            request.open("POST", "/user/delPraise");
            // 3.请求头
            request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
            // 4.设置数据
            request.send("praise_id=" + praise_id);
            // 5.监听服务器响应
            request.onreadystatechange = function () {
                if (request.readyState == 4 && request.status == 200) {
                    if (request.responseText == "1") {
                        layer.msg('删除成功', {
                            time: 2000
                        })
                        // 这有点快
                        window.location.reload();
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
