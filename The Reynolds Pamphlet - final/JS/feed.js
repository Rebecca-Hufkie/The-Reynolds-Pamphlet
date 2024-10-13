//DELETE TEXT IN FEEDBACK FORM
document.getElementById("DeleteText").addEventListener("click", () => {
    document.getElementById("feedback").value = "";
});

function adjustLayoutOnResize() {
    const columns = document.querySelectorAll('.column');
    const width = window.innerWidth;

    if (width < 600) {
        columns.forEach(col => col.style.width = '100%');
    } else if (width < 900) {
        columns.forEach(col => col.style.width = '48%');
    } else {
        columns.forEach(col => col.style.width = '30%');
    }
}

function highlightInput(event) {
    event.target.style.borderColor = 'blue';
    event.target.style.backgroundColor = '#e6f7ff'; // Light blue background
    event.target.style.boxShadow = '0 0 5px rgba(0, 123, 255, 0.5)'; // Subtle glow effect
}

function resetInput(event) {
    event.target.style.borderColor = '';
    event.target.style.backgroundColor = '';
    event.target.style.boxShadow = '';

    if (!event.target.value) {
        const errorMessage = document.createElement('span');
        errorMessage.style.color = 'red';
        errorMessage.style.fontSize = '12px';
        errorMessage.className = 'error-message';
        event.target.parentNode.insertBefore(errorMessage, event.target.nextSibling);
        
        setTimeout(() => {
            errorMessage.remove();
        }, 3000);
    }
}

function initializeEventListeners() {
    const inputs = document.querySelectorAll('input, textarea');
    inputs.forEach(input => {
        input.addEventListener('focus', highlightInput);
        input.addEventListener('blur', resetInput);
    });
}

// Call initializeEventListeners on page load
window.onload = initializeEventListeners;

