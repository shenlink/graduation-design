function checkPassword() {
    // 获取用户名输入框元素
    let password = document.querySelector('#password').value;
    let conPassword = document.querySelector('#confirmPassword').value;
    if (password === conPassword) {
        return true;
    } else {
        console.log(password);
        console.log(conPassword);
        layer.msg('两次密码不一致', {
            time: 2000
        });
        return false;
    }
}

$('#change').on('click', function () {
    // 获取用户名输入框元素
    let username = document.querySelector('#username').value;
    // 获取密码输入框元素
    let password = document.querySelector('#password').value;
    if (checkPassword()) {
        // 1.创建XMLHttpRequest对象
        let request = null;
        if (XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else {
            //兼容老IE浏览器
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        // 2.请求行
        request.open("POST", "/user/checkChange");
        // 3.请求头
        request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
        // 4.设置数据
        request.send("username=" + username + "&password=" + password);
        // request.send("username="+userval+"&age="+ageval+"&timp"+new Date().getTime());
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "1") {
                    layer.msg('修改成功', {
                        time: 1000
                    }, function (index, layero) {
                        location.href = '/user/login';
                        layero.close(index);
                    });
                } else {
                    layer.msg('修改失败', {
                        time: 1000
                    })
                }
            }
        }
    }
});