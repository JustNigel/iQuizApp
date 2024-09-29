import '@fortawesome/fontawesome-free/css/all.min.css';

import './bootstrap';

import Alpine from 'alpinejs';

import './questionnaire';

window.Alpine = Alpine;

Alpine.start();

function togglePasswordVisibility(fieldId) {
  const passwordField = document.getElementById(fieldId);
  const eyeIcon = document.getElementById('eyeIcon');
  
  if (passwordField.type === 'password') {
      passwordField.type = 'text';
      eyeIcon.classList.remove('fa-eye');
      eyeIcon.classList.add('fa-eye-slash');
  } else {
      passwordField.type = 'password';
      eyeIcon.classList.remove('fa-eye-slash');
      eyeIcon.classList.add('fa-eye');
  }
}

window.togglePasswordVisibility = togglePasswordVisibility;
