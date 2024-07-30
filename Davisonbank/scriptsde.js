function validateForm() {
    const checkNumber = document.getElementById("check_number").value;
    const amount = document.getElementById("amount").value;
    const checkImage = document.getElementById("check_image").files[0];

    if (!checkNumber || !amount || !checkImage) {
        alert("Please fill out all required fields and upload a check image.");
        return false;
    }

    // Additional validation checks can be added here
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Check Deposit Page Loaded');
    });
    

    return true;
}
