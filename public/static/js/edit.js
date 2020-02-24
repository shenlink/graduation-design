function check() {
    let title = document.querySelector('#title');
    let content = document.querySelector('#content');
    if (title.match(/^[ ]+$/) || title == '') {
        layer.msg('标题不能为空', {
            time: 1000
        });
        return false;
    }
    // 还得判断是不是全部是空格
    if (content.match(/^[ ]+$/) || content == '') {
        layer.msg('内容不能为空', {
            time: 1000
        });
        return false;
    }
    return true;
}


$('#edit').on('click', function () {
    let title = document.querySelector('#title');
    let content = document.querySelector('#content');
    if (check()) {
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
        request.open("POST", "/user/checkEdit");
        // 3.请求头
        request.setRequestHeader('Content-Type', ' application/x-www-form-urlencoded');
        // 4.设置数据
        request.send("article_id" + article_id + "&title=" + title + "&content=" + content);
        // 5.监听服务器响应
        request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
                if (request.responseText == "1") {
                    layer.msg('更改成功', {
                            time: 1000
                        },function (index, layero) {
                            location.href = '/user/manage';
                            layero.close(index);
                        });
                } else {
                    layer.msg('更改失败', {
                        time: 1000
                    })
                }
            }
        }
    }
});