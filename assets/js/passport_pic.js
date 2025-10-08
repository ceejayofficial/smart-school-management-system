// Passport preview with validations
const passportInput = document.getElementById('passport');
const passportPreview = document.getElementById('passportPreview');
const uploadText = document.getElementById('uploadText');

passportInput.addEventListener('change', function() {
    const file = this.files[0];
    if(file){
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 200 * 1024; // 200 KB

        // Validate file type
        if(!allowedTypes.includes(file.type)){
            alert("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
            this.value = ""; // reset input
            passportPreview.classList.add('hidden');
            uploadText.classList.remove('hidden');
            return;
        }

        // Validate file size
        if(file.size > maxSize){
            alert("File is too large. Maximum allowed size is 200KB.");
            this.value = ""; // reset input
            passportPreview.classList.add('hidden');
            uploadText.classList.remove('hidden');
            return;
        }

        // Preview the image
        const reader = new FileReader();
        reader.onload = function(e){
            passportPreview.src = e.target.result;
            passportPreview.classList.remove('hidden');
            uploadText.classList.add('hidden');
        }
        reader.readAsDataURL(file);
    }
});
