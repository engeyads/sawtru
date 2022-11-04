
const html1 = document.documentElement;
const body1 = document.body;
const menuLinks1 = document.querySelectorAll(".admin-menu a");
const collapseBtn1 = document.querySelector(".admin-menu .collapse-btn");
const toggleMobileMenu1 = document.querySelector(".toggle-mob-menu");
const switchInput1 = document.querySelector(".switch input");
const switchLabel1 = document.querySelector(".switch label");
const switchLabelText1 = switchLabel1.querySelector("span:last-child");
const collapsedClass1 = "collapsed";
const lightModeClass1 = "light-mode";

/*TOGGLE HEADER STATE*/
collapseBtn1.addEventListener("click", function () {
  body1.classList.toggle(collapsedClass1);
  this.getAttribute("aria-expanded") == "true"
    ? this.setAttribute("aria-expanded", "false")
    : this.setAttribute("aria-expanded", "true");
  this.getAttribute("aria-label") == "collapse menu"
    ? this.setAttribute("aria-label", "expand menu")
    : this.setAttribute("aria-label", "collapse menu");
});

/*TOGGLE MOBILE MENU*/
toggleMobileMenu1.addEventListener("click", function () {
  body1.classList.toggle("mob-menu-opened");
  this.getAttribute("aria-expanded") == "true"
    ? this.setAttribute("aria-expanded", "false")
    : this.setAttribute("aria-expanded", "true");
  this.getAttribute("aria-label") == "open menu"
    ? this.setAttribute("aria-label", "close menu")
    : this.setAttribute("aria-label", "open menu");
});

/*SHOW TOOLTIP ON MENU LINK HOVER*/
for (const link of menuLinks1) {
  link.addEventListener("mouseenter", function () {
    if (
      body1.classList.contains(collapsedClass1) &&
      window.matchMedia("(min-width: 768px)").matches
    ) {
      const tooltip = this.querySelector("span").textContent;
      this.setAttribute("title", tooltip);
    } else {
      this.removeAttribute("title");
    }
  });
}



/*TOGGLE LIGHT/DARK MODE*/
if (localStorage.getItem("dark-mode") === "false") {
  html1.classList.add(lightModeClass1);
  switchInput1.checked = false;
  switchLabelText1.textContent = "Light";
}

switchInput1.addEventListener("input", function () {
  html1.classList.toggle(lightModeClass1);
  if (html1.classList.contains(lightModeClass1)) {
    switchLabelText1.textContent = "Light";
    localStorage.setItem("dark-mode", "false");
  } else {
    switchLabelText1.textContent = "Dark";
    localStorage.setItem("dark-mode", "true");
  }
});

var rjs_cursor =  document.getElementById("rjs_cursor"); //Getting the cursor
var body =  document.querySelector("body"); //Get the body element

//Functions for showing and hiding the cursor
//They are referenced the
function rjs_show_cursor(e) { //Function to show/hide the cursor
if(rjs_cursor.classList.contains('rjs_cursor_hidden')) {
    rjs_cursor.classList.remove('rjs_cursor_hidden');
}
rjs_cursor.classList.add('rjs_cursor_visible');
}

function rjs_hide_cursor(e) {    if(rjs_cursor.classList.contains('rjs_cursor_visible')) {
rjs_cursor.classList.remove('rjs_cursor_visible');
}
rjs_cursor.classList.add('rjs_cursor_hidden');
}


function rjs_mousemove(e) { //Function to correctly position the cursor
rjs_show_cursor(); //Toggle show/hide

var rjs_cursor_width = rjs_cursor.offsetWidth * 0.5;
var rjs_cursor_height = rjs_cursor.offsetHeight * 0.5;

var rjs_cursor_x = e.clientX - rjs_cursor_width; //x-coordinate
var rjs_cursor_y = e.clientY - rjs_cursor_height; //y-coordinate
var rjs_cursor_pos = `translate(${rjs_cursor_x}px, ${rjs_cursor_y}px)`;
rjs_cursor.style.transform = rjs_cursor_pos;
}


//Eventlisteners
window.addEventListener('mousemove', rjs_mousemove); //Attach an event listener
body.addEventListener('mouseleave', rjs_hide_cursor);



//Hover behaviour
function rjs_hover_cursor(e) { rjs_cursor.classList.add('rjs_cursor_hover'); }
function rjs_unhover_cursor(e) { rjs_cursor.classList.remove('rjs_cursor_hover'); }


document.querySelectorAll('a').forEach(item => {
item.addEventListener('mouseover', rjs_hover_cursor);
item.addEventListener('mouseleave', rjs_unhover_cursor);
})

document.querySelectorAll('input').forEach(item => { //Input tags
item.addEventListener('mouseover', rjs_hover_cursor);
item.addEventListener('mouseleave', rjs_unhover_cursor);
})

document.querySelectorAll('button').forEach(item => { //Input tags
item.addEventListener('mouseover', rjs_hover_cursor);
item.addEventListener('mouseleave', rjs_unhover_cursor);
})

document.querySelectorAll('.mycustomclass').forEach(item => { //A custom class
item.addEventListener('mouseover', rjs_hover_cursor);
item.addEventListener('mouseleave', rjs_unhover_cursor);
})
