// 如果用户点击当前页，应该禁止

function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
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
    let input = createPageInput('pageNumber', pagination);
    form.appendChild(input);
    form.method = 'post';
    form.action = '/';
    form.submit();
}


function createPageInput(name, value) {
    let input = document.createElement('input');
    input.type = 'hidden';
    input.name = name;
    input.value = value;
    return input;
}