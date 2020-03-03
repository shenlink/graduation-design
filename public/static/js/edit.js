$('#edit').on('click', function () {
    let title = document.querySelector('#title').value;
    let content = editor.txt.html();
    let category = document.querySelector('#category').value;
    let content_text = editor.txt.text();
    if (title.match(/^[ ]+$/) || title.length == 0) {
        layer.msg('标题不能为空', {
            time: 1000
        });
        return;
    }
    if (content_text.match(/^[ ]+$/) || content_text.length == 0) {
        layer.msg('文章内容不能为空', {
            time: 1000
        });
        return;
    }
    let article_id = this.getAttribute('data-editArticle')
    // 1.创建XMLHttpRequest对象
    let request = null;
    if (XMLHttpRequest) {
        request = new XMLHttpRequest();
    } else {
        //兼容老IE浏览器
        request = new ActiveXObject("Msxml2.XMLHTTP");
    }
    // 2.请求行
    request.open("POST", "/article/checkEdit");
    // 3.请求头
    request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
    // 4.设置数据
    request.send("article_id=" + article_id + "&title=" + title + "&content=" + content + "&category=" + category);
    // 5.监听服务器响应
    request.onreadystatechange = function () {
        if (request.readyState == 4 && request.status == 200) {
            if (request.responseText == "1") {
                layer.msg('更改成功', {
                    time: 1000
                }, function () {
                    location.href = '/user/manage';
                });
            } else {
                layer.msg('更改失败', {
                    time: 1000
                })
            }
        }
    }
});