$('#addCategory').on('click', function () {
    let categoryName = document.querySelector('#categoryName').value;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/category/checkAddCategory");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("categoryName=" + categoryName);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('添加成功', {
                    time: 2000
                }, function () {
                    window.history.back(-1);
                });
            } else {
                layer.msg('添加失败', {
                    time: 2000
                });
            }
        }
    }
});


$('#addAnnouncement').on('click', function () {
    let content = document.querySelector('#content').value;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/announcement/checkAddAnnouncement");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("content=" + content);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('添加成功', {
                    time: 1000
                }, function () {
                    window.history.back(-1);
                });
            } else {
                layer.msg('添加失败', {
                    time: 1000
                })
            }
        }
    }
});


$('#addMessage').on('click', function () {
    let content = document.querySelector('#content').value;
    let author = document.querySelector('#author').value;
    let username = document.querySelector('#username').value;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/message/checkAddMessage");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("author=" + author + "&username=" + username + "&content=" + content);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('发送成功', {
                    time: 1000
                }, function () {
                    window.history.back(-1);
                });
            } else {
                layer.msg('发送失败', {
                    time: 1000
                })
            }
        }
    }
});