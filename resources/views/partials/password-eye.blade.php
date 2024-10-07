<script>
    function togglePasswordVisibility(inputId, iconId = null) {
        const input = document.getElementById(inputId);

        let icon;
        // If iconId is passed, use it, otherwise locate the icon dynamically
        if (iconId) {
            icon = document.getElementById(iconId);
        } else {
            icon = input.closest('div').querySelector('i');
        }

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

</script>
