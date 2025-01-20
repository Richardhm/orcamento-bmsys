import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
// Seleciona o botão de alternância e o elemento <html>
const themeToggle = document.getElementById('theme-toggle');
const htmlElement = document.documentElement;

// Verifica se o localStorage tem uma preferência de tema
const storedTheme = localStorage.getItem('theme');

// Aplica o tema padrão (light) se nenhuma preferência for encontrada
if (storedTheme === 'dark') {
    htmlElement.classList.add('dark');
} else {
    htmlElement.classList.remove('dark');
    localStorage.setItem('theme', 'light'); // Define "light" como padrão
}

// Alterna entre os temas quando o botão é clicado
themeToggle.addEventListener('click', () => {
    if (htmlElement.classList.contains('dark')) {
        htmlElement.classList.remove('dark');
        localStorage.setItem('theme', 'light');
    } else {
        htmlElement.classList.add('dark');
        localStorage.setItem('theme', 'dark');
    }
});

