
//ZOOMS INTO PROFILE PICTURE WHEN CLICKED
// Get the modal
document.addEventListener("DOMContentLoaded",function(){
// Get the modal
var modal = document.getElementById("myModal");

// Get the image and insert it inside the modal
var img = document.getElementById("myImg");
var modalImg = document.getElementById("img01");

// Open the modal when the image is clicked
img.onclick = function() {
  modal.style.display = "block";
  modalImg.src = this.src;
}

// Close the modal
var span = document.getElementsByClassName("close")[0];
span.onclick = function() { 
  modal.style.display = "none";
}

});


//DELETE
document.addEventListener("DOMContentLoaded", function() {
  const DeleteButton = document.getElementById("delete-account");
  const confirmButton = document.getElementById("confirmButton");
  const cancelButton = document.getElementById("cancelButton");
  const popup = document.getElementById("delete-popup");
  const closeBtn = document.querySelector(".close-btn");

  // Show popup when logout button is clicked
  DeleteButton.addEventListener("click", function(event) {
    event.preventDefault(); // Prevent the default behavior
    popup.style.display = "block"; // Show the popup
  });

  // Handle confirmation
  confirmButton.addEventListener("click", function() {
    // Logic to log the user out
    window.location.href = "deactivate.php"; // Replace with your actual logout URL
  });

  // Handle cancel action
  cancelButton.addEventListener("click", function() {
    popup.style.display = "none"; // Hide the popup
  });

  // Close popup when close button is clicked
  closeBtn.addEventListener("click", function() {
    popup.style.display = "none";
  });

  // Close popup if user clicks outside of popup content
  window.addEventListener("click", function(event) {
    if (event.target == popup) {
      popup.style.display = "none";
    }
  });
});


document.addEventListener('DOMContentLoaded', function() {
  // Your existing JavaScript code here
  const editButton = document.getElementById('edit-profile');
  const saveButton = document.getElementById('save-Button');
  // const detailsDisplay = document.getElementById('card-container');

  const current_details = document.getElementById('card-container');
  const edit_form = document.getElementById('edit_profile_form');
  
  // // form element to be displayed
  // const detailsEdit = document.getElementById('edit_profile_form');
  
   const FirstNameDisplay = document.getElementById('Firstname-display');
   const emailDisplay = document.getElementById('email-display');
   const usernameInput = document.getElementById('user-name');
   const emailInput = document.getElementById('user-email');

  // //Error message elements
  const emailErr = document.getElementById('emailError');
  const nameErr = document.getElementById('nameError');

  emailErr.textContent = '';
  nameErr.textContent = '';

  
  // // Edit button click event
  editButton.addEventListener('click', function() {
     current_details.style.display = 'none';  // Hide the display view
     edit_form.style.display = 'block';    // Show the edit view
  
     editButton.style.display = 'none';
     saveButton.style.display = 'inline-block';
   });

  // Save button click event
  saveButton.addEventListener('click', function() {
    // Update displayed values

    emailErr.textContent = '';
    nameErr.textContent = '';


    isValid = true;
    
    if (usernameInput.value.trim() === '') {
      nameErr.textContent = 'Name is required';
      isValid = false;
    } else {
      FirstNameDisplay.textContent = usernameInput.value;
    }

    if(!ValidateEmail(emailInput.value)){
      emailErr.textContent = 'Please ensure that your email is valid';
      isValid = false;
    } else if (emailInput.value.trim() === '') {
      nameErr.textContent = 'Email is required';
      isValid = false;
    } else {
      emailDisplay.textContent = emailInput.value;
    }

    if(isValid) {
      // Switch back to the display view
      edit_form.style.display = 'none';
      current_details.style.display = 'block';

      saveButton.style.display = 'none';
      editButton.style.display = 'inline-block';
    }
  });

  function ValidateEmail(email) {
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    return emailPattern.test(email);
  }
});






