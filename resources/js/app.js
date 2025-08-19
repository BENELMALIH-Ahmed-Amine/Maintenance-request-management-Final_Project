import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


// Set registeration role:
if (role.value == 2) {
    category.classList.remove("hidden")
    category.classList.add("flex")
}
role.addEventListener('change', () => {
    if (role.value == 2) {
        category.classList.remove("hidden")
        category.classList.add("flex")
    } else {
        category.classList.add("hidden")
        category.classList.remove("flex")
    }
})