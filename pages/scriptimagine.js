document.addEventListener('DOMContentLoaded', () => {
    const imageSelect = document.getElementById('imageSelect');
    const imageContainer = document.querySelector('.image-container');
    const image = document.getElementById('image');
    const frameButtons = document.querySelectorAll('.frame-btn');

    // Fetch image names from PHP
    fetch('get_images.php')
        .then(response => response.json())
        .then(imageNames => {
            imageNames.forEach(name => {
                const option = document.createElement('option');
                option.value = name;
                option.textContent = name;
                imageSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error fetching image names:', error));

    // Handle image selection
    imageSelect.addEventListener('change', () => {
        const selectedImage = imageSelect.value;
        if (selectedImage) {
            image.src = `images/${selectedImage}`;
            image.style.display = 'block';
        } else {
            image.src = '';
            image.style.display = 'none';
        }
    });

    frameButtons.forEach(button => {
        button.addEventListener('click', () => {
            const frameStyle = button.getAttribute('data-frame');
            applyFrame(frameStyle);
        });
    });

    function applyFrame(frameStyle) {
        imageContainer.className = 'image-container'; // Reset classes
        if (frameStyle !== 'none') {
            imageContainer.classList.add(frameStyle);
        }
    }
});
