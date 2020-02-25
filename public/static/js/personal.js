$('#follow').on('click', function () {
    let follow = document.querySelector('#follow');
    let username = follow.getAttribute('data-username');
    let author = follow.getAttribute('data-author');
    if (username == '') {
        layer.msg('登录才能关注', {
            time: 2000
        });
    } else {
        // 1.创建XMLHttpRequest对象
        let request = null;
        if (XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else {
            //兼容老IE浏览器
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        // 2.请求行
        request.open("POST", "/follows/checkFollows");
        // 3.请求头
        request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
        // 4.设置数据
        request.send("author=" + author + "&username=" + username);
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "关注成功") {
                    layer.msg('关注成功', {
                        time: 1000
                    });
                    follow.innerHTML = '已关注';
                } else if (request.responseText == "关注失败") {
                    layer.msg('关注失败', {
                        time: 1000
                    });
                } else if (request.responseText == "取消关注成功") {
                    layer.msg('取消关注成功', {
                        time: 1000
                    });
                    follow.innerHTML = '关注';
                } else {
                    layer.msg('取消关注失败', {
                        time: 1000
                    });
                }
            }
        }
    }
});