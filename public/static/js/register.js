// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    let searchContent = $('#searchContent').val;
    if (searchContent === '') {
        layer.msg('查询条件不能为空', {
            time: 1000
        });
        return;
    }
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


// 确认用户名
function checkUsername() {
    let username = $('#username');
    let usernameValue = username.value;
    let userMessage = $('#userMessage');
    if (usernameValue.length === 0) {
        username.className = "form-control is-invalid"
        userMessage.innerHTML = `<span style="color:red;">用户名不能为空</span>`;
        return false;
    }
    let reg = /^(?=.*[A-Za-z])|(?=.*[0-9]){4,16}$/;
    if (reg.test(usernameValue)) {
        userMessage.innerHTML = `<span style="color:green;">用户名符合要求</span>`;
    } else {
        userMessage.innerHTML = `<span style="color:red;">用户名不符合要求</span>`;
        return false;
    }
    // ajax验证用户名是否被注册
    if (usernameValue.length > 0) {
        // 1.创建XMLHttpRequest对象
        let request = null;
        if (XMLHttpRequest) {
            request = new XMLHttpRequest();
        } else {
            //兼容老IE浏览器
            request = new ActiveXObject("Msxml2.XMLHTTP");
        }
        // 2.请求行
        request.open("POST", "/user/checkUsername");
        // 3.请求头
        request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
        // 4.设置数据
        request.send("username=" + usernameValue);
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "1") {
                    userMessage.innerHTML = `<span style="color:red;">用户名已被注册</span>`;
                } else {
                    userMessage.innerHTML = `<span  style="color:green;">用户名未被注册</span>`;
                }
            }
        }
        return true;
    }
}


function checkAjax() {
    let userMessage = $('#userMessage');
    if (userMessage.style.color == 'red') {
        return false;
    } else {
        return true;
    }
}


// 确认密码是否符合要求
function checkPassword() {
    let password = $('#password');
    let passwordValue = password.value;
    let passwordTip = $('#passwordTip');
    if (passwordValue.length === 0) {
        password.className = "form-control is-invalid"
        passwordTip.innerHTML = `<span style="color:red;">密码不能为空</span>`;
        return false;
    } else if (passwordValue.length < 6 || passwordValue.length > 16) {
        passwordTip.innerHTML = `<span style="color:red;">密码位数不符合要求,要求6到16位</span>`;
        return false;
    } else {
        // 正则表达式正向预查，匹配含数字，小写字母，大写字母和特殊字符的字符串
        let reg = /(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[\W_]).{6,16}/;
        if (reg.test(passwordValue)) {
            passwordTip.innerHTML = `<span style="color:green;">密码符合要求</span>`;
            return true;
        } else {
            passwordTip.innerHTML = `<span style="color:red;">密码不符合要求</span>`;
            return false;
        }
    }
}


// 确认密码
function checkConPassword() {
    let password = $('#password');
    let passwordValue = password.value;
    let confirmPassword = $('#confirmPassword');
    let conPasswordValue = confirmPassword.value;
    let conPasswordTip = $('#conPasswordTip');
    if (conPasswordValue.length === 0) {
        confirmPassword.className = "form-control is-invalid"
        conPasswordTip.innerHTML = `<span style="color:red;">确认密码不能为空</span>`;
        return false;
    }
    if (passwordValue === conPasswordValue) {
        conPasswordTip.innerHTML = `<span style="color:green;">两次密码一致</span>`;
        return true;
    } else {
        conPasswordTip.innerHTML = `<span style="color:red;">两次密码不一致</span>`;
        return false;
    }
}


// 用户名输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function userOriginal() {
    let username = $('#username');
    let userMessage = $('#userMessage');
    username.className = "form-control"
    userMessage.innerHTML = `<img src="/static/image/mess.png" id="userImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请输入用户名，用户名至少包含1个字母，可以包含数字，4到16位`;
}


// 密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function passwordOriginal() {
    let password = $('#password');
    let passwordTip = $('#passwordTip');
    password.className = "form-control"
    passwordTip.innerHTML = `<img src="/static/image/mess.png" id="passwordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码为6到16位，且必须包含数字，小写字母，大写字母和特殊字符`;
}


// 确认密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function conPasswordOriginal() {
    conPasswordTip.innerHTML = `<img src="/static/image/mess.png" id="conPasswordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    确认密码 `;
}


// 获取眼睛图案
let passwordEye = $('#passwordEye');
// 这个变量的声明不能放在函数内，若放在函数内，那每次点击调用函数时，均会flag = false
let flag = false;
function clickEye() {
    if (flag == false) {
        // 把密码输入的框变成文本输入框
        password.type = 'text';
        // 切换成睁眼的图片
        passwordEye.src = '/static/image/open.png';
        // 改变图片的alt值
        passwordEye.alt = '隐藏密码';
        // flag置true,下次再点击就切换成闭眼的图片
        flag = true;
    } else {
        // 把密码输入的框变成文本输入框
        password.type = 'password';
        // 切换成睁眼的图片
        passwordEye.src = '/static/image/close.png';
        // 改变图片的alt值
        passwordEye.alt = '显示密码';
        // flag置false,下次再点击就切换成睁眼的图片
        flag = false;
    }
}


// 获取眼睛图案
let conPasswordEye = $('#conPasswordEye');
// 这个变量的声明不能放在函数内
let conFlag = false;
// 这个变量的声明不能放在函数内，若放在函数内，那每次点击调用函数时，均会conFlag = false
function clickConEye() {
    if (conFlag == false) {
        // 把密码输入的框变成文本输入框
        confirmPassword.type = 'text';
        // 切换成睁眼的图片
        conPasswordEye.src = '/static/image/open.png';
        // conflag置true,下次再点击就切换成闭眼的图片
        conFlag = true;
    } else {
        // 把密码输入的框变成文本输入框
        confirmPassword.type = 'password';
        // 切换成睁眼的图片
        conPasswordEye.src = '/static/image/close.png';
        // conflag置false,下次再点击就切换成睁眼的图片
        conFlag = false;
    }
}


// 表单提交验证
function check() {
    return checkUsername() && checkAjax() && checkPassword() && checkConPassword();
}


$('#register').on('click', function () {
    // 获取输入的用户名的值
    let username = $('#username').val();
    // 获取输入的密码的值
    let password = $('#password').val();
    if (check()) {
        $.post("/user/checkRegister", {
            username: username,
            password: password
        }, function (data) {
            if (data === '1') {
                layer.msg('注册成功', {
                    time: 1000
                }, function () {
                    location.href = '/user/login';
                });
            } else {
                layer.msg('注册失败', {
                    time: 1000
                });
            }
        });
    }
});