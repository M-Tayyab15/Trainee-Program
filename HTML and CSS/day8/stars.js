document.addEventListener('DOMContentLoaded', () => {
    const stars = document.querySelectorAll('.rating input');
    
    stars.forEach(star => {
        star.addEventListener('change', () => {
            const rating = document.querySelector('input[name="rating"]:checked').value;
            console.log(`Rating is: ${rating} stars`);
        });
    });
});
