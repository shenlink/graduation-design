// 搜索
$('#search').on('click', function () {
    let type = document.querySelector('#type').value;
    let searchContent = document.querySelector('#searchContent').value;
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


function checkUsername() {
    // 这三个元素得放在函数内，因为每次失去焦点后，都能够重新获得输入框的值内容，方便后面判断
    // 获取用户名输入框元素
    let username = document.querySelector('#username');
    // 获取输入的用户名的值
    let usernameValue = username.value;
    // 获取提示用户注意的信息的节点元素
    let userMessage = document.querySelector('#userMessage');
    // 用户名输入框为空时
    if (usernameValue.length === 0) {
        username.className = "form-control is-invalid"
        userMessage.innerHTML = `<span style="color:red;">用户名不能为空</span>`;
        return false;
    } else {
        return true;
    }
}


function checkPassword() {
    // 这三个元素得放在函数内，因为每次失去焦点后，都能够重新获得输入框的值内容，方便后面判断
    // 获取密码输入框元素
    let password = document.querySelector('#password');
    // 获取输入的密码的值
    let passwordValue = password.value;
    // 获取提示用户注意的信息的节点元素
    let passwordTip = document.querySelector('#passwordTip');
    // 密码输入框为空时
    if (passwordValue.length === 0) {
        password.className = "form-control is-invalid"
        passwordTip.innerHTML = `<span style="color:red;">密码不能为空</span>`;
        return false;
    } else {
        return true;
    }
}


// 用户名输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function userOriginal() {
    // 其实这两条语句是不用加的，但是感觉怪怪的，就加上了
    let username = document.querySelector('#username');
    // 获取提示用户注意的信息的节点元素
    let userMessage = document.querySelector('#userMessage');
    // 还原输入框的初始样式
    username.className = "form-control"
    userMessage.innerHTML = `<img src="/static/image/mess.png" id="userImg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请输入用户名`;
}


// 密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function passwordOriginal() {
    // 获取密码输入框元素
    let password = document.querySelector('#password');
    // 获取提示用户注意的信息的节点元素
    let passwordTip = document.querySelector('#passwordTip');
    // 还原输入框的初始样式
    password.className = "form-control"
    passwordTip.innerHTML = `<img src="/static/image/mess.png" id="passwordImg">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;请输入密码`;
}


// 获取眼睛图案
let passwordEye = document.querySelector('#passwordEye');
let flag = false;
// 这个变量的声明不能放在函数内，若放在函数内，那每次点击调用函数时，均会flag = false
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


function check() {
    return checkUsername() && checkPassword();
}


$('#login').on('click', function () {
    // 获取输入的用户名的值
    let username = document.querySelector('#username').value;
    // 获取输入的密码的值
    let password = document.querySelector('#password').value;
    if (check()) {
        $.post("/user/checkLogin", {
            username: username,
            password: password
        }, function (data) {
            if (data === '1') {
                layer.msg('登录成功', {
                    time: 1000
                }, function () {
                    location.href = '/';
                });
            } else {
                layer.msg('登录失败', {
                    time: 1000
                });
            }
        });
    }
});