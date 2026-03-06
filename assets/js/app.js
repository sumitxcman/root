// Generic function to delete any item (User, Product, etc.)
function deleteItem(id, type) {
    if (!confirm("Are you sure you want to delete this?")) {
        return; // Stop if they clicked Cancel
    }

    // Call the API
    // Note: We use dynamic URL based on 'type' (users or products)
    fetch(`../api/${type}/delete.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id: id })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Deleted successfully!');
            location.reload(); // Refresh the table
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => console.error('Error:', error));
}
