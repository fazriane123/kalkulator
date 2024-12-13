const themeToggle = document.getElementById('themeToggle'); 
const currentTheme = localStorage.getItem('theme'); 
if (currentTheme === 'dark') { 
document.body.classList.add('dark-mode'); 
themeToggle.checked = true; 
} 
themeToggle.addEventListener('change', () => { 
if (themeToggle.checked) { 
document.body.classList.add('dark-mode'); 
localStorage.setItem('theme', 'dark'); 
} else { 
document.body.classList.remove('dark-mode'); 
localStorage.setItem('theme', 'light'); 
} 
});