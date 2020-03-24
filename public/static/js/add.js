// 搜索
$('#search').on('click', function () {
    let type = $('#type').val();
    let searchContent = $('#searchContent').val();
    if (searchContent == '') {
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


// 添加分类
$('#addCategory').on('click', function () {
    let categoryName = $('#categoryName').val();
    $.post("/category/checkAddCategory", {
        categoryName: categoryName
    }, function (data) {
        if (data === '1') {
            layer.msg('添加成功', {
                time: 1000
            }, function () {
                window.history.back(-1);
            });
        } else {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});


// 添加公告
$('#addAnnouncement').on('click', function () {
    let content = $('#content').val();
    $.post("/announcement/checkAddAnnouncement", {
        content: content
    }, function (data) {
        if (data === '1') {
            layer.msg('添加成功', {
                time: 1000
            }, function () {
                window.history.back(-1);
            });
        } else {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});


// 发私信
$('#addMessage').on('click', function () {
    let author = $('#author').val();
    let content = $('#content').val();
    $.post("/message/checkAddMessage", {
        author: author,
        content: content
    }, function (data) {
        if (data === '1') {
            layer.msg('添加成功', {
                time: 1000
            }, function () {
                window.history.back(-1);
            });
        } else {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});