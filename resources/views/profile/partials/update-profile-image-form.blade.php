<form action="{{ route('profile.update-image') }}" method="POST" enctype="multipart/form-data">
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
