function validateForm() {
    const accountNumber = document.getElementById('account_number').value;
    const bankName = document.getElementById('bank_name').value;
    const routingNumber = document.getElementById('routing_number').value;
    const amount = document.getElementById('amount').value;

    if (!accountNumber || !bankName || !routingNumber || !amount) {
        alert('Please fill out all required fields.');
        return false;
    }

    if (isNaN(amount) || amount <= 0) {
        alert('Please enter a valid amount.');
        return false;
    }

    return true;
}
