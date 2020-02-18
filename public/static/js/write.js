function check() {
    let title = document.querySelector('#title');
    let content = document.querySelector('#content');
    if (title == '') {
        layer.msg('标题不能为空', {
            time: 1000
        });
        return false;
    }
    if (content == '') {
        layer.msg('标题不能为空', {
            time: 1000
        });
        return false;
    }
    return true;
}

$('#publish').on('click', function () {
    let title = document.querySelector('#title');
    let content = document.querySelector('#content');
    if (check()) {
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
        request.send("title=" + title + "&content=" + content);
        // request.send("username="+userval+"&age="+ageval+"&timp"+new Date().getTime());
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "1") {
                    layer.msg('发布成功', {
                        time: 1000
                    }, function (index, layero) {
                        location.href = '/user/personal';
                        layero.close(index);
                    });
                } else {
                    layer.msg('发布失败', {
                        time: 1000
                    })
                }
            }
        }
    }
});