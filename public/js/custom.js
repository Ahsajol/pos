document.addEventListener('DOMContentLoaded', (event) => {
    const statusCheckbox = document.getElementById('status');
    const statusLabel = document.querySelector('label[for="status"]');

    // Update the label based on the checkbox state
    statusCheckbox.addEventListener('change', function () {
        if (this.checked) {
            statusLabel.textContent = 'Active';
            this.value = '1';
        } else {
            statusLabel.textContent = 'Inactive';
            this.value = '0'; // Set value to 0 when unchecked
        }
    });

    // Set initial label text based on initial checkbox state
    if (statusCheckbox.checked) {
        statusLabel.textContent = 'Active';
    } else {
        statusLabel.textContent = 'Inactive';
        statusCheckbox.value = '0'; // Set value to 0 when unchecked
    }
});