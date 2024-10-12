// category dropdown functionality
jQuery(document).ready(function ($) {
  $("#categoryButton").on("click", function () {
    $("#categoryList").toggle();
  });
});

// sticky header functionality
document.addEventListener("DOMContentLoaded", function () {
  var mainbar = document.getElementById("stickyHeader");
  var sticky = mainbar.offsetTop;

  function handleScroll() {
    if (window.pageYOffset > sticky) {
      mainbar.classList.add("sticky");
    } else {
      mainbar.classList.remove("sticky");
    }
  }

  window.addEventListener("scroll", handleScroll);
});

// mobiel menu functionality
document.addEventListener("DOMContentLoaded", function () {
  const menuIcon = document.querySelector(".menu-icon");
  const sidebar = document.querySelector(".sidebar");
  const closeIcon = document.querySelector(".close-icon");

  menuIcon.addEventListener("click", function () {
    sidebar.classList.add("open");
  });

  closeIcon.addEventListener("click", function () {
    sidebar.classList.remove("open");
  });
});
