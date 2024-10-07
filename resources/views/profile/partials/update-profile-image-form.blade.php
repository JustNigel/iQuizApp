<form id="uploadForm" action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="flex items-center space-x-6">
        <div class="shrink-0">
            @if(auth()->user()->image_profile)
                <img id="profileImagePreview" src="{{ asset('images/profiles/' . auth()->user()->image_profile) }}" alt="Profile Picture" class="h-16 w-16 rounded-full object-cover">
            @else
                <i class="fas fa-user-circle text-gray-400 text-4xl"></i>
            @endif
        </div>
        <label class="block">
            <span class="sr-only">Choose profile photo</span>
            <input type="file" id="profileImageInput" name="image_profile" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
        </label>
    </div>

    <!-- Cropping Area -->
    <div class="mt-4">
        <img id="croppingImage" class="hidden" alt="Cropping Image">
    </div>

    <div class="mt-4">
        <button type="button" id="cropButton" class="px-4 py-2 bg-indigo-600 text-white rounded-md hidden">Crop & Upload</button>
    </div>

    <input type="hidden" id="croppedImage" name="cropped_image">
</form>

<script>
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

            // Submit the form
            let uploadForm = document.getElementById('uploadForm');
            if (uploadForm) {
                uploadForm.submit();
            } else {
                console.error('Form #uploadForm not found!');
            }
        }
    });
});
</script>
