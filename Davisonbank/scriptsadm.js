document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('username');
    userSelect.addEventListener('change', function() {
        const selectedUsername = userSelect.value;
        if (selectedUsername) {
            fetch(`http://localhost/davisonbank/admin_manage_users.php?username=${encodeURIComponent(selectedUsername)}`)
                .then(response => response.text())
                .then(data => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(data, 'text/html');
                    const userDetails = doc.querySelector('#user-details');
                    if (userDetails) {
                        document.querySelector('#user-details').outerHTML = userDetails.outerHTML;
                    }
                    // Reattach event listener for the update form after user details are loaded
                    attachUpdateUserFormListener();
                })
                .catch(error => console.error('Error fetching user details:', error));
        }
    });

    function attachUpdateUserFormListener() {
        const updateUserForm = document.getElementById('update-user-form');
        if (updateUserForm) {
            updateUserForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent default form submission
                const formData = new FormData(updateUserForm);
                fetch('http://localhost/davisonbank/process_admin_user.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('User details updated successfully');
                    } else {
                        alert('Error updating user details: ' + data.message);
                    }
                })
                .catch(error => console.error('Error updating user details:', error));
            });
        }
    }

    // Initial attachment of the event listener
    attachUpdateUserFormListener();
});
