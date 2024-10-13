document.addEventListener('DOMContentLoaded', function() {
    // Select the necessary elements from the DOM
    const form = document.getElementById('confession-form');
    const formContainer = document.getElementById('form-container');
    const envelope = document.getElementById('envelope');
    const flap = document.querySelector('#envelope .flap');
    const seal = document.querySelector('#envelope .seal');
    const submitButton = document.getElementById('submit-confession-btn');

    // Add event listener for form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission to allow the animation

        // Disable the submit button to prevent double submissions and show a loading state
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        // Start the folding animation and proceed to submit after it completes
        startFoldingAnimation().then(() => {
            // Check if the form is still valid before submitting it
            if (form.checkValidity()) {
                form.submit(); // Programmatically submit the form after the animation completes
            } else {
                console.error("Form is not valid");
                // Re-enable the submit button if the form is not valid
                submitButton.disabled = false;
                submitButton.textContent = 'Submit Confession';
            }
        }).catch((error) => {
            console.error("Error during animation:", error);
            // Fallback: Allow the form to submit without the animation if there's an error
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Confession';
            form.submit();
        });
    });

    // Function to handle the folding animation
    function startFoldingAnimation() {
        // Return a Promise that resolves when the animation completes or rejects if there's an error
        return new Promise((resolve, reject) => {
            try {
                // Scale down the form container vertically (simulate folding)
                formContainer.style.transition = 'transform 0.8s ease-in-out, opacity 0.5s ease-in-out';
                formContainer.style.transform = 'scaleY(0)';
                formContainer.style.opacity = '0';

                // Show the envelope after the form is folded
                setTimeout(() => {
                    envelope.classList.remove('hidden');
                    envelope.style.opacity = '1';

                    // Animate the flap to close the envelope
                    setTimeout(() => {
                        flap.style.transform = 'rotateX(-180deg)'; // Rotate the flap to close

                        // Seal the envelope after the flap animation completes
                        setTimeout(() => {
                            seal.style.display = 'block'; // Make the seal visible
                            resolve(); // Resolve the promise indicating the animation completed successfully
                        }, 500); // Delay for the seal animation
                        
                    }, 1000); // Delay for flap animation
                }, 800); // Delay for envelope to appear after the form folds
            } catch (error) {
                reject(error); // Reject the promise if there's an error during the animation
            }
        });
    }
});
