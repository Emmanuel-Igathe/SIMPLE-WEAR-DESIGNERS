// Function to change product image based on color selection
function changeImage(color) {
    const mainImage = document.getElementById('mainImage');
    mainImage.src = `images/tshirt-${color}.jpg`;
    
    // Update active color dot
    document.querySelectorAll('.color-dot').forEach(dot => {
        dot.style.borderColor = 'transparent';
    });
    event.target.style.borderColor = '#333';
}

// Quantity adjustment
function adjustQuantity(change) {
    const quantityElement = event.target.closest('.quantity-selector').querySelector('.quantity');
    let quantity = parseInt(quantityElement.textContent);
    quantity += change;
    
    if (quantity < 1) quantity = 1;
    if (quantity > 10) quantity = 10;
    
    quantityElement.textContent = quantity;
    updateCartTotals();
}

// Remove item from cart
function removeItem() {
    if (confirm('Remove this item from your cart?')) {
        event.target.closest('.cart-item').remove();
        updateCartTotals();
    }
}

// Update cart totals (simplified example)
function updateCartTotals() {
    // In a real app, you would recalculate all prices here
    console.log('Cart updated');
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize cart functionality
});