function edit() {
    let form = document.createElement("form");
    document.body.appendChild(form);
    let edit = document.querySelector('#edit');
    let article_id = edit.getAttribute('data-edit');
    let input = createInput('article_id', article_id);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/user/edit';
    form.submit();
}

function createInput(name,value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


$('#del').on('click', function () {

    let del = document.querySelector('#del');
    let article_id = del.getAttribute('data-del')
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/user/deleteArticle");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('删除成功', {
                        time: 1000
                    },function (index, layero) {
                        window.location.reload();
                        layero.close(index);
                    });

            } else {
                layer.msg('删除失败', {
                    time: 1000
                })
            }
        }
    }
});