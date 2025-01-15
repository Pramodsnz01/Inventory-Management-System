// var sidebarOpen = true;
// document.getElementById('toggle_btn').addEventListener('click', (event) => {
//     event.preventDefault();
//     const sidebar = document.getElementById('dashboard_sidebar');
//     const contentContainer = document.getElementById('dashboard_content_container');
//     const logo = document.getElementById('dashboard_logo');
//     const userImage = document.getElementById('userImage');
//     const menuText = document.getElementsByClassName('menuText');

//     if (sidebarOpen) {
//         sidebar.style.width = '10%';
//         sidebar.style.transition = '0.3s all';
//         contentContainer.style.width = '90%';
//         // logo.style.fontSize = '50px';
//         userImage.style.width = '60px';
//         for (let i = 0; i < menuText.length; i++) {
//             menuText[i].style.display = 'none';
//         }
//         sidebarOpen = false;
//     } else {
//         sidebar.style.width = '25%';
//         contentContainer.style.width = '80%';
//         // logo.style.fontSize = '60px';
//         userImage.style.width = '80px';
//         for (let i = 0; i < menuText.length; i++) {
//             menuText[i].style.display = 'inline-block';
//         }
//         sidebarOpen = true;
//     }
// });


// sub menu show/hide fn
document.addEventListener('click', function (e) {
    let clickedElement = e.target;

    if (clickedElement.classList.contains('showHideSubMenu')) {
        let subMenu = clickedElement.closest('li').querySelector('.subMenus'); 
        let mainMenuIcon = clickedElement.closest('li').querySelector('.leftAngleIcon'); 

        //close all sub menu
        let subMenus = document.querySelectorAll('.subMenus');
        subMenus.forEach((sub) => {
            if (subMenu !== sub) sub.style.display ='none';
        });

        // call function to show/hide sub menu
        showHideSubMenu(subMenu, mainMenuIcon);
    }
});

//function to show/hide sub menu
function showHideSubMenu(subMenu, mainMenuIcon) {
    if (subMenu != null) { 
        subMenu.style.display = subMenu.style.display === 'block' ? 'none' : 'block'; 

        if (subMenu.style.display === 'block') {
            mainMenuIcon.classList.add('rotate-down'); 
        } else {
            mainMenuIcon.classList.remove('rotate-down');  
        }
    } else {
        console.error("data-subMenu attribute is missing or undefined");
    }
}


//Add-hide active class to the menu
//Get the current page
//Use the selector to get the current menu or submenu
//Add the active class 

const pathArray = window.location.pathname.split('/')
let curFile = pathArray[pathArray.length - 1]
let curNav = document.querySelector('a[href="./' + curFile + '"]')
curNav.classList.add('subMenuActive');

let mainNav = curNav.closest('li.liMainMenu')
mainNav.style.background = '#f685a1'

let subMenu = curNav.closest('.subMenus')
let mainMenuIcon = mainNav.querySelector('i.leftAngleIcon'); 
 

// call function to show/hide sub menu
showHideSubMenu(subMenu, mainMenuIcon);