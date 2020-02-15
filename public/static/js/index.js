let search = document.querySelector('#search');

function search() {
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

}