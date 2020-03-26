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
    if (type == '1') {
        window.location.href = '/user/search/username/' + searchContent;
    } else {
        window.location.href = '/article/search/condition/' + searchContent;
    }
});

// 分页
function changePage(page) {
    let temp = page;
    let pagination = temp.getAttribute('data-index');
    if (pagination == 'current_1') {
        layer.msg('已经是第一页了', {
            time: 1000
        });
        return;
    }
    if (pagination == 'current_page') {
        layer.msg('已经是当前页了', {
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
}

// 页数跳转
function jumpPage(pages) {
    let temp = pages;
    let type = temp.getAttribute('data-type');
    let pagination = $('#paginationJump').val();
    window.location.href = `/index/index/${type}/${pagination}`;
}