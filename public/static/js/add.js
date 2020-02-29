$('#addCategory').on('click', function () {
    let category = document.querySelector('#category').value;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/admin/checkAdd");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("category=" + category);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('添加成功', {
                    time: 2000
                });
            } else {
                layer.msg('添加失败', {
                    time: 2000
                });
            }
            window.history.back(-1);
        }
    }
});


$('#addAnnouncement').on('click', function () {
    let announcement = document.querySelector('#announcement').value;
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/user/checkRegister");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("announcement=" + announcement);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('添加成功', {
                    time: 1000
                });
            } else {
                layer.msg('添加失败', {
                    time: 1000
                })
            }
        }
    }
});


$('#addInformation').on('click', function () {
    let information = document.querySelector('#information').value;
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
    request.open("POST", "/user/checkRegister");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("information=" + information + "&author=" + author + "&username" + username);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('发送成功', {
                    time: 1000
                });
            } else {
                layer.msg('发送失败', {
                    time: 1000
                })
            }
        }
    }
});