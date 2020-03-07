$('#follow').on('click', function () {
    let follow = document.querySelector('#follow');
    let username = follow.getAttribute('data-username');
    let author = follow.getAttribute('data-author');
    if (username == '') {
        layer.msg('登录才能关注', {
            time: 2000
        });
        return;
    }
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/follow/checkFollow");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("author=" + author + "&username=" + username);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('关注成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                });
            } else {
                layer.msg('取消关注成功', {
                    time: 1000
                }, function () {
                    window.location.reload();
                });
            }
        }
    }
});



function addMessage() {
    let message = document.querySelector('#message');
    let author = message.getAttribute('data-author');
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createMessageInput('author', author);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/message/addMessage';
    form.submit();
}

function createMessageInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}

function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
    let author = document.querySelector('#author').getAttribute('data-author');
    if (pagination == 'current_1') {
        layer.msg('已经是第一页了', {
            time: 1000
        });
        return;
    }
    if (pagination == 'current_end') {
        layer.msg('已经是末页了', {
            time: 1000
        });
        return;
    }
    let form = document.createElement("form");
    document.body.appendChild(form);
    let input = createPageInput('pagination', pagination);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/user/' + author;
    form.submit();
}


function createPageInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}