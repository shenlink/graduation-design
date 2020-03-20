// 搜索
$('#search').on('click', function () {
    let type = document.querySelector('#type').value;
    let searchContent = document.querySelector('#searchContent').value;
    let form = document.createElement("form");
    document.body.appendChild(form);
    switch (type) {
        case '1':
            input1 = createSearchInput('type', 'user');
            break;
        case '2':
            input1 = createSearchInput('type', 'article');
            break;
    }
    let input2 = createSearchInput('content', searchContent);
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

function createSearchInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}


$('#addCategory').on('click', function () {
    let categoryName = document.querySelector('#categoryName').value;
    $.post("/category/checkAddCategory", {
        categoryName: categoryName
    }, function (data) {
        if (data === '1') {
            layer.msg('添加成功', {
                time: 1000
            }, function () {
                window.history.back(-1);
            });
        }
        if (data === '0') {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});


$('#addAnnouncement').on('click', function () {
    let content = document.querySelector('#content').value;
    $.post("/announcement/checkAddAnnouncement", {
        content: content
    }, function (data) {
        if (data === '1') {
            layer.msg('添加成功', {
                time: 1000
            }, function () {
                window.history.back(-1);
            });
        }
        if (data === '0') {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});


$('#addMessage').on('click', function () {
    let author = document.querySelector('#author').value;
    let content = document.querySelector('#content').value;
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
        }
        if (data === '0') {
            layer.msg('添加失败', {
                time: 1000
            });
        }
    });
});