// You can add JavaScript validation or functionality here if needed
document.getElementById('transfer-form').addEventListener('submit', function (e) {
    // Example: Validate SWIFT code format
    const swiftCode = document.getElementById('swift-code').value;
    const swiftCodeRegex = /^[A-Z]{4}[A-Z]{2}[A-Z2-9]{2}([A-Z0-9]{3})?$/;

    if (!swiftCodeRegex.test(swiftCode)) {
        alert('Please enter a valid SWIFT code.');
        e.preventDefault();
    }
});
