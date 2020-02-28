let lis = document.querySelector('.manage-ul').querySelectorAll('.manage-list');
let items = document.querySelectorAll('.manage-item');
// for循环在页面加载完成之后就已经执行完了，这时候lis的index索引已经赋值完成,然后执行lis[i].click事件注册，待点击之后就触发
for (let i = 0; i < lis.length; i++) {
    lis[i].setAttribute('index', i);
    lis[i].onclick = function () {
        for (let i = 0; i < lis.length; i++) {
            lis[i].className = 'h4 manage-list';
        }
        this.className = 'h4 manage-list current';
        let index = this.getAttribute('index');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = 'none';
        }
        items[index].style.display = 'block';
    }
}



