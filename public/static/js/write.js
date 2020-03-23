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


// 发表文章
let E = window.wangEditor;
let editor = new E('#content');
editor.create();
$('#publish').on('click', function () {
    let title = $('#title').val();
    let html = editor.txt.html();
    let content = filterXSS(html);
    let category = $('#category').val();
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
    $.post("/article/checkWrite", {
        title: title,
        content: content,
        category: category
    }, function (data) {
        if (data === '1') {
            layer.msg('发布成功', {
                time: 1000
            }, function () {
                window.location.href = '/user/personal';
            });
        } else {
            layer.msg('发布失败', {
                time: 1000
            });
        }
    });
});