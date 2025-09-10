document.addEventListener('DOMContentLoaded', function() {
    // Get references to the DOM elements
    const organisationInput = document.getElementById('organisation');
    const loginFields = document.getElementById('loginFields');
    const datalist = document.getElementById('organisationList');
    
    // Add event listener to the organisation input
    organisationInput.addEventListener('change', function() {
        // Check if an organisation was selected
        if (this.value.trim() !== '') {
            // Show the login fields
            loginFields.classList.remove('hidden');
            
            // Add a smooth transition effect
            loginFields.style.opacity = '0';
            setTimeout(() => {
                loginFields.style.transition = 'opacity 0.3s ease-in-out';
                loginFields.style.opacity = '1';
            }, 10);
        } else {
            // Hide the login fields if no organisation is selected
            loginFields.classList.add('hidden');
        }
    });
    
    // Optional: Add input event for real-time filtering
    organisationInput.addEventListener('input', function() {
        const inputValue = this.value.toLowerCase();
        const options = datalist.querySelectorAll('option');
        
        // For better UX, we could implement custom filtering here
        // but the datalist element handles this automatically
    });
});