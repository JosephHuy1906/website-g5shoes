var btnMenuSidebar = document.querySelector('.header__actions-menu');
var sidebar = document.querySelector('.sidebar');
var btnClose = document.querySelector('.sidebar__wrapper-close');
var authSidebar = document.querySelector('.sidebar__wrapper');

function showSidebar() {
    sidebar.classList.add('active');
}

function hideSidebar() {
    sidebar.classList.remove('active');
}

btnMenuSidebar.addEventListener('click', showSidebar);
btnClose.addEventListener('click', hideSidebar);
sidebar.addEventListener('click', hideSidebar);
authSidebar.addEventListener('click', e => {
    e.stopPropagation();
})

//profile

