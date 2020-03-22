// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    let searchContent = $('#searchContent').val();
    let form = document.createElement("form");
    document.body.appendChild(form);
    switch (type) {
        case '1':
            input1 = createInput('type', 'user');
            break;
        case '2':
            input1 = createInput('type', 'article');
            break;
    }
    let input2 = createInput('content', searchContent);
    form.appendChild(input1);
    form.appendChild(input2);
    form.method = 'post';
    if (type == '1') {
        form.action = '/user/search';
    } else {
        form.action = '/article/search';
    }
    form.submit();
});


function createInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


// 确认密码是否符合要求
function checkPassword() {
    let password = $('#password');
    let passwordValue = password.val();
    let passwordTip = $('#passwordTip');
    if (passwordValue.length === 0) {
        password.attr('class', "form-control is-invalid");
        passwordTip.html(`<span style="color:red;">密码不能为空</span>`);
        return false;
    } else if (passwordValue.length < 6 || passwordValue.length > 16) {
        passwordTip.html(`<span style="color:red;">密码位数不符合要求,要求6到16位</span>`);
        return false;
    } else {
        // 正则表达式正向预查，匹配含数字，小写字母，大写字母和特殊字符的字符串
        let reg = /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,16}/;
        if (reg.test(passwordValue)) {
            passwordTip.html(`<span style="color:green;">密码符合要求</span>`);
            return true;
        } else {
            passwordTip.html(`<span style="color:red;">密码不符合要求</span>`);
            return false;
        }
    }
}


// 确认密码
function checkConPassword() {
    let password = $('#password');
    let passwordValue = password.value;
    let confirmPassword = $('#confirmPassword');
    let conPasswordValue = confirmPassword.val();
    let conPasswordTip = $('#conPasswordTip');
    if (conPasswordValue.length === 0) {
        confirmPassword.attr('class', "form-control is-invalid");
        conPasswordTip.html(`<span style="color:red;">确认密码不能为空</span>`);
        return false;
    }
    if (passwordValue === conPasswordValue) {
        conPasswordTip.html(`<span style="color:green;">两次密码一致</span>`);
        return true;
    } else {
        conPasswordTip.html(`<span style="color:red;">两次密码不一致</span>`);
        return false;
    }
}


function passwordOriginal() {
    let password = $('#password');
    let passwordTip = $('#passwordTip');
    password.attr('class', "form-control");
    passwordTip.html(`<img src="/static/image/mess.png" id="passwordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码为6到16位，且必须包含数字，小写字母，大写字母和特殊字符`);
}


// 确认密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function conPasswordOriginal() {
    let confirmPassword = $('#confirmPassword');
    let conPasswordTip = $('#conPasswordTip');
    confirmPassword.attr('class', "form-control");
    conPasswordTip.html(`<img src="/static/image/mess.png" id="conPasswordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    确认密码 `);
}


// 获取眼睛图案
let passwordEye = $('#passwordEye');
let flag = false;

function clickEye() {
    if (flag == false) {
        password.type = 'text';
        passwordEye.src = '/static/image/open.png';
        passwordEye.alt = '隐藏密码';
        flag = true;
    } else {
        password.type = 'password';
        passwordEye.src = '/static/image/close.png';
        passwordEye.alt = '显示密码';
        flag = false;
    }
}


// 获取眼睛图案
let conPasswordEye = $('#conPasswordEye');
let conFlag = false;

function clickConEye() {
    if (conFlag == false) {
        confirmPassword.type = 'text';
        conPasswordEye.src = '/static/image/open.png';
        conFlag = true;
    } else {
        confirmPassword.type = 'password';
        conPasswordEye.src = '/static/image/close.png';
        conFlag = false;
    }
}


// 表单提交验证
function check() {
    return checkPassword() && checkConPassword();
}


$('#change').on('click', function () {
    let username = $('#username').val();
    let password = $('#password').val();
    let introduction = $('#introduction').val();
    if (check()) {
        $.post("/user/checkChange", {
            username: username,
            password: password,
            introduction: introduction
        }, function (data) {
            if (data === '1') {
                layer.msg('修改成功', {
                    time: 1000
                }, function () {
                    location.href = '/user/personal';
                });
            } else {
                layer.msg('修改失败', {
                    time: 1000
                });
            }
        });
    }
});