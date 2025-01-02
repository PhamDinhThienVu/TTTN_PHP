/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
// 

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar 
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});


document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("image-modal");
    const modalImg = document.getElementById("modal-image");
    const closeBtn = document.querySelector(".close-modal");

    let scale = 1; // Biến lưu trạng thái zoom
    let startX = 0, startY = 0, moveX = 0, moveY = 0; // Biến để kéo ảnh

    // Lặp qua tất cả các ảnh trong dòng thời gian
    document.querySelectorAll(".timeline-image img").forEach((img) => {
        img.addEventListener("click", function () {
            modal.style.display = "block"; // Hiển thị modal
            modalImg.src = this.src; // Gán ảnh vào modal
            document.body.classList.add("modal-open"); // Ngăn cuộn trang
            resetZoom(); // Đặt lại trạng thái zoom khi mở ảnh mới
        });
    });

    // Đóng modal khi nhấn nút close
    closeBtn.addEventListener("click", function () {
        modal.style.display = "none";
        document.body.classList.remove("modal-open");
    });

    // Đóng modal khi nhấn ra ngoài
    modal.addEventListener("click", function (e) {
        if (e.target === modal) {
            modal.style.display = "none";
            document.body.classList.remove("modal-open");
        }
    });

    // Thêm sự kiện zoom ảnh bằng con lăn chuột
    modalImg.addEventListener("wheel", function (e) {
        e.preventDefault();
        const zoomStep = 0.1;
        if (e.deltaY < 0) {
            scale += zoomStep; // Zoom in
        } else if (e.deltaY > 0) {
            scale = Math.max(1, scale - zoomStep); // Zoom out (không nhỏ hơn 1)
        }
        modalImg.style.transform = `scale(${scale})`;
    });

    // Thêm sự kiện kéo ảnh khi đã zoom
    modalImg.addEventListener("mousedown", function (e) {
        if (scale > 1) {
            e.preventDefault();
            startX = e.clientX - moveX;
            startY = e.clientY - moveY;

            document.addEventListener("mousemove", onMouseMove);
            document.addEventListener("mouseup", onMouseUp);
        }
    });

    function onMouseMove(e) {
        moveX = e.clientX - startX;
        moveY = e.clientY - startY;
        modalImg.style.transform = `scale(${scale}) translate(${moveX}px, ${moveY}px)`;
    }

    function onMouseUp() {
        document.removeEventListener("mousemove", onMouseMove);
        document.removeEventListener("mouseup", onMouseUp);
    }

    // Đặt lại trạng thái zoom
    function resetZoom() {
        scale = 1;
        moveX = 0;
        moveY = 0;
        modalImg.style.transform = "scale(1)";
    }
});




document.addEventListener("DOMContentLoaded", function () {
    const zaloLink = document.getElementById("zalo-link");
    const facebookLink = document.getElementById("facebook-link");

    // Kiểm tra thiết bị
    const isMobile = /iPhone|iPad|iPod|Android/i.test(navigator.userAgent);

    // Đường dẫn đến Zalo
    const zaloMobileURL = "https://zalo.me/0343881447"; 
    const zaloDesktopURL = "https://zalo.me/0343881447";

    // Đường dẫn đến Facebook
    const facebookMobileURL = "fb://page/zuck/"; // Liên kết native cho app Facebook
    const facebookDesktopURL = "https://www.facebook.com/zuck/";

    // Cập nhật URL Zalo
    zaloLink.href = isMobile ? zaloMobileURL : zaloDesktopURL;

    // Cập nhật URL Facebook
    facebookLink.href = isMobile ? facebookMobileURL : facebookDesktopURL;

    // Nếu muốn, có thể hiển thị cảnh báo khi liên kết không hoạt động trên một số thiết bị
    facebookLink.addEventListener("click", function (e) {
        if (isMobile && !navigator.userAgent.includes("FBAN")) {
            alert("Ứng dụng Facebook chưa được cài đặt trên thiết bị của bạn.");
        }
    });
});