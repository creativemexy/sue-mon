// Main JavaScript file for Sue & Mon

// Utility Functions
const Utils = {
    // Format price in Nigerian Naira
    formatPrice: (price) => {
        return '₦' + (price / 100).toFixed(2);
    },

    // Show notification
    showNotification: (message, type = 'success') => {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg ${
            type === 'success' ? 'bg-green-500 text-white' : 
            type === 'error' ? 'bg-red-500 text-white' : 
            'bg-blue-500 text-white'
        }`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
};

// Cart Management
const Cart = {
    addItem: (productId, quantity = 1) => {
        fetch('/api/cart/add.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Utils.showNotification('Product added to cart!');
                location.reload();
            } else {
                Utils.showNotification(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error adding to cart:', error);
            Utils.showNotification('Error adding to cart', 'error');
        });
    },

    updateQuantity: (productId, quantity) => {
        fetch('/api/cart/update.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId,
                quantity: quantity
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
        });
    },

    removeItem: (productId) => {
        fetch('/api/cart/remove.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Utils.showNotification('Product removed from cart');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error removing from cart:', error);
        });
    }
};

// Search Functionality
const Search = {
    performSearch: (query) => {
        if (query.length < 2) {
            Search.clearResults();
            return;
        }

        fetch('/api/search.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                query: query
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Search.displayResults(data.products);
            }
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    },

    displayResults: (products) => {
        const resultsContainer = document.getElementById('search-results');
        if (!resultsContainer) return;

        if (products.length === 0) {
            resultsContainer.innerHTML = `
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-search text-2xl mb-2"></i>
                    <p>No products found</p>
                </div>
            `;
            return;
        }

        let html = '<div class="p-6 space-y-4">';
        
        products.forEach(product => {
            html += `
                <a href="/product?id=${product.id}" class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                    <img src="/assets${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded-md">
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900">${product.name}</h3>
                        <p class="text-sm text-gray-600">${product.category}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-medium text-gray-900">${Utils.formatPrice(product.price)}</p>
                    </div>
                </a>
            `;
        });
        
        html += '</div>';
        resultsContainer.innerHTML = html;
    },

    clearResults: () => {
        const resultsContainer = document.getElementById('search-results');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
        }
    }
};

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize search functionality
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                Search.performSearch(e.target.value);
            }, 300);
        });
    }

    // Close modals when clicking outside
    document.addEventListener('click', (e) => {
        if (e.target.classList.contains('modal')) {
            e.target.classList.add('hidden');
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.classList.add('hidden');
            });
        }
    });
});

// Global functions for backward compatibility
window.addToCart = Cart.addItem;
window.removeFromCart = Cart.removeItem;
window.updateCartQuantity = Cart.updateQuantity; 