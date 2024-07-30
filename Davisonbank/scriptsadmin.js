document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('.sidebar a');
    const contentArea = document.getElementById('content-area');

    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const contentType = this.getAttribute('data-content');
            loadContent(contentType);
        });
    });

    function loadContent(type) {
        switch(type) {
            case 'manage-users':
                fetchContent('admin_manage_users.php');
                break;
            case 'manage-transfers':
                fetchContent('admin_manage_users_transfers.php');
                break;
            case 'internal-transfers':
                fetchContent('admin_internal_transfers.php');
                break;
            case 'external-transfers':
                fetchContent('admin_external_transfers.php');
                break;
            case 'admin-profile':
                contentArea.innerHTML = '<h2>Admin Profile</h2><p>Content for the admin profile.</p>';
                break;
            case 'settings':
                fetchContent('settingsad.php');
                break;
            default:
                contentArea.innerHTML = '<p>Select an option from the sidebar to view content.</p>';
        }
    }

    function fetchContent(file) {
        console.log('Fetching content from:', file); // Debugging line
        fetch(file)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text();
            })
            .then(data => {
                contentArea.innerHTML = data;
            })
            .catch(error => {
                contentArea.innerHTML = '<p>Error loading content.</p>';
                console.error('Error loading content:', error);
            });
    }
});
