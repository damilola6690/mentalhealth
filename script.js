document.addEventListener('DOMContentLoaded', function () {
    const appointmentForm = document.getElementById('appointmentForm');
    appointmentForm.addEventListener('submit', function (event) {
        event.preventDefault();

        const firstName = document.getElementById('firstName').value;
        const lastName = document.getElementById('lastName').value;
        // Retrieve other form data here...

        // Check if email is already in the file (you need server-side code for this)
        // Check if the date/time is available (you need server-side code for this)

        // If validations pass, you can submit the data using AJAX to the server.
        // Example using Fetch API:
        fetch('your-server-endpoint-url', {
            method: 'POST',
            body: JSON.stringify({
                firstName,
                lastName,
                // Other form data...
            }),
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Appointment booked successfully
                alert('Appointment booked successfully!');
            } else {
                // Handle errors (e.g., email already exists)
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
});