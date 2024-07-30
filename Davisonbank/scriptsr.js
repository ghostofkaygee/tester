document.addEventListener("DOMContentLoaded", function() {
    fetch("fetch_transactions.php")
        .then(response => response.json())
        .then(transactions => {
            const tableBody = document.querySelector("#transaction-table tbody");
            tableBody.innerHTML = "";

            transactions.forEach(transaction => {
                const row = document.createElement("tr");

                row.innerHTML = `
                    <td>${transaction.type}</td>
                    <td>${transaction.recipient_name || transaction.recipient_user_id || '-'}</td>
                    <td>${transaction.recipient_bank || '-'}</td>
                    <td>${transaction.account_number || '-'}</td>
                    <td>${transaction.swift_code || '-'}</td>
                    <td>${transaction.amount}</td>
                    <td>${transaction.notes}</td>
                    <td>${transaction.status}</td>
                    <td>${new Date(transaction.created_at).toLocaleString()}</td>
                `;

                tableBody.appendChild(row);
            });
        })
        .catch(error => console.error('Error fetching transactions:', error));
});
