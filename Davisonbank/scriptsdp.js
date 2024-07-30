document.addEventListener('DOMContentLoaded', function() {
    const profilePhotoInput = document.getElementById('profile_photo');
    const preview = document.getElementById('preview');
    const errorMessage = document.getElementById('errorMessage');
    const uploadForm = document.getElementById('upload_Form');

    // Image preview
    profilePhotoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });

    // Form validation
    uploadForm.addEventListener('submit', function(event) {
        errorMessage.innerHTML = '';  // Clear previous errors
        const file = profilePhotoInput.files[0];

        if (file) {
            const imageFileType = file.name.split('.').pop().toLowerCase();
            const validFileTypes = ['jpg', 'jpeg', 'png', 'gif'];
            const maxFileSize = 5 * 1024 * 1024; // 5MB

            if (!validFileTypes.includes(imageFileType)) {
                event.preventDefault();
                errorMessage.innerHTML = 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.';
                return;
            }

            if (file.size > maxFileSize) {
                event.preventDefault();
                errorMessage.innerHTML = 'Sorry, your file is too large. Maximum size is 5MB.';
                return;
            }
        } else {
            event.preventDefault();
            errorMessage.innerHTML = 'Please select a file to upload.';
        }
    });
});
