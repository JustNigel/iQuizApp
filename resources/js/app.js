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

document.addEventListener('DOMContentLoaded', function () {
    let cropper;

    // File input change event
    document.getElementById('profileImageInput').addEventListener('change', function (event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function (e) {
            let image = document.getElementById('croppingImage');
            image.src = e.target.result;
            image.classList.remove('hidden');

            // Destroy the previous cropper instance if any
            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(image, {
                aspectRatio: 1, // Square crop
                viewMode: 2,
                autoCropArea: 1,
                movable: true,
                scalable: true,
                zoomable: true,
            });

            document.getElementById('cropButton').classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    });

    // Crop button click event
    document.getElementById('cropButton').addEventListener('click', function () {
        if (cropper) {
            let croppedCanvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
            });

            // Convert the canvas to a Base64 encoded image
            document.getElementById('croppedImage').value = croppedCanvas.toDataURL('image/jpeg');

            // Check if the preview image exists
            let profileImagePreview = document.getElementById('profileImagePreview');
            if (profileImagePreview) {
                // Update the preview image
                profileImagePreview.src = croppedCanvas.toDataURL('image/jpeg');
            }

            // Find the form and submit it
            let uploadForm = document.getElementById('uploadForm');
            if (uploadForm) {
                uploadForm.submit();
            } else {
                console.error('Form #uploadForm not found!');
            }
        }
    });
});
