// 确认密码是否符合要求
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
    } else if (passwordValue.length < 6 || passwordValue.length > 16) {
        // 密码位数不符合要求
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
    // 这三个元素得放在函数内，因为每次失去焦点后，都能够重新获得输入框的值内容，方便后面判断
    // 获取密码输入框元素
    let password = document.querySelector('#password');
    // 获取输入的密码的值
    let passwordValue = password.value;
    // 获取确认密码输入框元素
    let confirmPassword = document.querySelector('#confirmPassword');
    // 获取确认密码的值
    let conPasswordValue = confirmPassword.value;
    // 获取提示用户注意的信息的节点元素
    let conPasswordTip = document.querySelector('#conPasswordTip');
    // 确认密码输入框为空时
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

// 密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function passwordOriginal() {
    // 获取密码输入框元素
    let password = document.querySelector('#password');
    // 获取提示用户注意的信息的节点元素
    let passwordTip = document.querySelector('#passwordTip');
    // 还原输入框的初始样式
    password.className = "form-control"
    passwordTip.innerHTML = `<img src="/static/image/mess.png" id="passwordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;密码为6到16位，且必须包含数字，小写字母，大写字母和特殊字符`;
}

// 确认密码输入框失去焦点后，再次获得焦点时，恢复到初始样式，提示也会恢复到初始值
function conPasswordOriginal() {
    // 获取确认密码输入框元素
    let confirmPassword = document.querySelector('#confirmPassword');
    // 获取提示用户注意的信息的节点元素
    let conPasswordTip = document.querySelector('#conPasswordTip');
    // 还原输入框的初始样式
    confirmPassword.className = "form-control"
    conPasswordTip.innerHTML = `<img src="/static/image/mess.png" id="conPasswordImg">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    确认密码 `;
}

// 获取眼睛图案
let passwordEye = document.querySelector('#passwordEye');
// 这个变量的声明不能放在函数内，若放在函数内，那每次点击调用函数时，均会flag = false
let flag = false;
//
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
let conPasswordEye = document.querySelector('#conPasswordEye');
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
    return checkPassword() && checkConPassword();
}
$('#change').on('click', function () {
    // 获取用户名输入框的值
    let username = document.querySelector('#username').value;
    // 获取密码输入框的值
    let password = document.querySelector('#password').value;
    let introduction = document.querySelector('#introduction').value;
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
        request.open("POST", "/user/checkChange");
        // 3.请求头
        request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
        // 4.设置数据
        request.send("username=" + username + "&password=" + password +"&introduction=" + introduction);
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "1") {
                    layer.msg('修改成功', {
                        time: 1000
                    }, function () {
                        location.href = '/user/personal';
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