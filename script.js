
const modal = document.querySelector('.modal');
const overlay = document.querySelector('.overlay');
const btnCloseModal = document.querySelector('.btn--close-modal');
const btnsOpenModal = document.querySelectorAll('.btn--show-modal');
const btnScrollTo = document.querySelector('.btn--scroll-to');
const section2 = document.querySelector('#section--2');
const nav = document.querySelector('.nav');
const tabs = document.querySelectorAll('.operations__tab');
const tabsContainer = document.querySelector('.operations__tab-container');
const tabsContent = document.querySelectorAll('.operations__content');


const carousel = document.querySelector(".carousel"),
    firstImg = carousel.querySelectorAll("img")[0];
arrowIcons = document.querySelectorAll(".wrapper i");

let isDragStart = false;
let startX;
let scrollLeft;
let firstImgWidth = firstImg.clientWidth + 14;

arrowIcons.forEach(icon => {
    icon.addEventListener("click", () => {
        carousel.scrollLeft += icon.id == "left" ? -firstImgWidth : firstImgWidth;
    });
});

const dragStart = (e) => {
    e.preventDefault();
    isDragStart = true;
    startX = e.pageX - carousel.offsetLeft;
    scrollLeft = carousel.scrollLeft;
}

const dragEnd = () => {
    isDragStart = false;
}

const dragging = (e) => {
    e.preventDefault();
    if (!isDragStart) return;
    const x = e.pageX - carousel.offsetLeft;
    const distance = x - startX;
    carousel.scrollLeft = scrollLeft - distance;
}

carousel.addEventListener("mousedown", dragStart);
carousel.addEventListener("mouseup", dragEnd);
carousel.addEventListener("mousemove", dragging);


const openModal = function (e) {
    e.preventDefault();
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
};

const closeModal = function () {
    modal.classList.add('hidden');
    overlay.classList.add('hidden');
};

btnsOpenModal.forEach(btn => btn.addEventListener('click', openModal));

btnCloseModal.addEventListener('click', closeModal);
overlay.addEventListener('click', closeModal);

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
        closeModal();
    }
});


// функція для додавання опцій до списку часу
function addOptionsToTimeSelect(hourStart, hourEnd) {
    const select = document.getElementById('time');
    select.innerHTML = '<option value="">-- Виберіть час --</option>';

    for (let hour = hourStart; hour <= hourEnd; hour++) {
        const option = document.createElement('option');
        option.value = hour + ':00';
        option.text = hour + ':00';
        select.appendChild(option);
    }
}

// функція для обробки вибору дати
function handleDateChange() {
    const dateInput = document.getElementById('date');
    const dayOfWeek = new Date(dateInput.value).getDay();

    if (dayOfWeek === 0) {
        addOptionsToTimeSelect(10, 17);
    } else {
        addOptionsToTimeSelect(9, 20);
    }
}

// додати обробник події для вибору дати
document.getElementById('date').addEventListener('change', handleDateChange);

// викликати функцію для відображення доступного часу при завантаженні сторінки
handleDateChange();

const links = document.querySelectorAll('.scroll-link');

// перебираємо посилання і додаємо обробник події "click"
links.forEach(link => {
    link.addEventListener('click', (event) => {
        event.preventDefault(); // відміняємо стандартну поведінку посилання
        const targetId = link.getAttribute('href'); // отримуємо ідентифікатор цільового елемента
        const targetElement = document.querySelector(targetId); // знаходимо цільовий елемент
        targetElement.scrollIntoView({ behavior: 'smooth' }); // плавно прокручуємо до цільового елемента
    });
});

function showPasswordPrompt() {
    var password = prompt("Введіть пароль:");

    // перевірка пароля в JS
    if (password == "") {
        alert("Пароль не може бути порожнім!");
    } else {
        // перенаправлення на PHP код для перевірки пароля
        window.location.href = "check_password.php?password=" + password;
    }


}
