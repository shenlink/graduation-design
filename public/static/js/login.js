// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    if (type == '2') {
        searchContent = encodeURIComponent($('#searchContent').val());
        if (searchContent == '') {
            layer.msg('查询条件不能为空', {
                time: 1000
            });
            return;
        }
    } else {
        searchContent = $('#searchContent').val();
        if (searchContent == '') {
            layer.msg('查询条件不能为空', {
                time: 1000
            });
            return;
        }
        let reg = /^(?=.*[a-z])[a-z0-9]{4,16}$/i;
        if (!reg.test(searchContent)) {
            layer.msg('用户名不符合要求', {
                time: 1000
            });
            return;
        }
    }
    if (type == '1') {
        window.location.href = `/user/search/${searchContent}/1.html`;
    } else {
        window.location.href = `/article/search/${searchContent}/1.html`;
    }
});

// 确认用户名
function checkUsername() {
    let username = $('#username');
    let usernameValue = username.val();
    let userMessage = $('#userMessage');
    if (usernameValue.length === 0) {
        username.attr('class', "form-control is-invalid");
        userMessage.html(`<span style="color:red;">用户名不能为空</span>`);
        return false;
    } else {
        return true;
    }
}

// 确认密码
function checkPassword() {
    let password = $('#password');
    let passwordValue = password.val();
    let passwordTip = $('#passwordTip');
    if (passwordValue.length === 0) {
        password.attr('class', "form-control is-invalid");
        passwordTip.html(`<span style="color:red;">密码不能为空</span>`);
        return false;
    } else {
        return true;
    }
}

function userOriginal() {
    let username = $('#username');
    let userMessage = $('#userMessage');
    username.attr('class', "form-control");
    userMessage.html(`<img src="/static/image/mess.png" id="userImg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请输入用户名`);
}

function passwordOriginal() {
    let password = $('#password');
    let passwordTip = $('#passwordTip');
    password.attr('class', "form-control");
    passwordTip.html(`<img src="/static/image/mess.png" id="passwordImg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请输入密码`);
}

// 获取眼睛图案
let passwordEye = $('#passwordEye');
let password = $('#password');
let flag = false;

function clickEye() {
    if (flag == false) {
        password.attr('type', 'text');
        passwordEye.attr('src', '/static/image/open.png');
        passwordEye.attr('alt', '隐藏密码');
        flag = true;
    } else {
        password.attr('type', 'password');
        passwordEye.attr('src', '/static/image/close.png');
        passwordEye.attr('alt', '显示密码');
        flag = false;
    }
}

function check() {
    return checkUsername() && checkPassword();
}

// 确认登录
$('#login').on('click', function () {
    let username = $('#username').val();
    let password = $('#password').val();
    if (check()) {
        $.post("/user/checkLogin", {
            username: username,
            password: password
        }, function (data) {
            if (data === '1') {
                layer.msg('登录成功', {
                    time: 1000
                }, function () {
                    window.location.href = '/';
                });
            } else if (data === '-1') {
                alert('用户因违规被封号，请联系管理员解禁，xxx@qq.com');
            } else {
                layer.msg('登录失败', {
                    time: 1000
                });
            }
        });
    }
});