// Main JavaScript file for Sue & Mon website

// Cart functionality
function addToCart(productId) {
    fetch('/api/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update cart count
            updateCartCount(data.cart_count);
            // Show success message
            showMessage('Product added to cart!', 'success');
            // Open cart sidebar
            openCartSidebar();
        } else {
            showMessage(data.message || 'Error adding to cart', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showMessage('Error adding to cart', 'error');
    });
}

function updateCartCount(count) {
    const cartBadge = document.querySelector('.cart-count');
    if (cartBadge) {
        cartBadge.textContent = count;
        if (count > 0) {
            cartBadge.classList.remove('hidden');
        } else {
            cartBadge.classList.add('hidden');
        }
    }
}

function openCartSidebar() {
    const cartSidebar = document.getElementById('cart-sidebar');
    if (cartSidebar) {
        cartSidebar.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }
}

function closeCartSidebar() {
    const cartSidebar = document.getElementById('cart-sidebar');
    if (cartSidebar) {
        cartSidebar.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
}

// Search functionality
function openSearchModal() {
    const searchModal = document.getElementById('search-modal');
    if (searchModal) {
        searchModal.classList.remove('hidden');
        document.getElementById('search-input').focus();
    }
}

function closeSearchModal() {
    const searchModal = document.getElementById('search-modal');
    if (searchModal) {
        searchModal.classList.add('hidden');
    }
}

// Mobile menu functionality
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('hidden');
    }
}

// Utility functions
function showMessage(message, type = 'success') {
    const messageDiv = document.createElement('div');
    messageDiv.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    messageDiv.textContent = message;
    
    document.body.appendChild(messageDiv);
    
    setTimeout(() => {
        messageDiv.remove();
    }, 3000);
}

// Format price utility
function formatPrice(price) {
    return '₦' + parseFloat(price).toLocaleString('en-NG');
}

// Wishlist functionality
function addToWishlist(productId) {
    // Implement wishlist functionality
    console.log('Add to wishlist:', productId);
    showMessage('Product added to wishlist!', 'success');
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Close modals when clicking outside
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            closeCartSidebar();
            closeSearchModal();
        }
    });
    
    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeCartSidebar();
            closeSearchModal();
        }
    });
}); 