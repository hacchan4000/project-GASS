const body = document.querySelector('body');
const sidebar = body.querySelector('.sidebar');
const toggle = body.querySelector('.toggle');
const searchBtn = body.querySelector('.search-box');


toggle.addEventListener("click", () =>{
    sidebar.classList.toggle("close")
})
