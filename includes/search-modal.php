<div id="search-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
    <div class="flex items-start justify-center min-h-screen pt-16 px-4">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-2xl max-h-96 overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Search Products</h2>
                <button onclick="closeSearchModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Search Input -->
            <div class="p-6">
                <div class="relative">
                    <input type="text" id="search-input" placeholder="Search for products..." 
                           class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           onkeyup="performSearch(this.value)">
                    <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <!-- Search Results -->
            <div id="search-results" class="max-h-64 overflow-y-auto">
                <!-- Results will be populated here -->
            </div>

            <!-- Popular Searches -->
            <div class="p-6 border-t border-gray-200">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Popular Searches</h3>
                <div class="flex flex-wrap gap-2">
                    <button onclick="searchFor('immunity')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                        Immunity
                    </button>
                    <button onclick="searchFor('detox')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                        Detox
                    </button>
                    <button onclick="searchFor('relaxation')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                        Relaxation
                    </button>
                    <button onclick="searchFor('energy')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                        Energy
                    </button>
                    <button onclick="searchFor('sleep')" class="px-3 py-1 bg-gray-100 text-gray-700 rounded-full text-sm hover:bg-gray-200 transition-colors">
                        Sleep
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let searchTimeout;

function openSearchModal() {
    document.getElementById('search-modal').classList.remove('hidden');
    document.getElementById('search-input').focus();
    document.body.style.overflow = 'hidden';
}

function closeSearchModal() {
    document.getElementById('search-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('search-input').value = '';
    document.getElementById('search-results').innerHTML = '';
}

function performSearch(query) {
    clearTimeout(searchTimeout);
    
    if (query.length < 2) {
        document.getElementById('search-results').innerHTML = '';
        return;
    }
    
    searchTimeout = setTimeout(() => {
        fetch('<?php echo url('api/search'); ?>', {
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
            displaySearchResults(data.products);
        })
        .catch(error => {
            console.error('Search error:', error);
        });
    }, 300);
}

function searchFor(term) {
    document.getElementById('search-input').value = term;
    performSearch(term);
}

function displaySearchResults(products) {
    const resultsContainer = document.getElementById('search-results');
    
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
            <a href="<?php echo url('product'); ?>?id=${product.id}" class="flex items-center space-x-4 p-3 hover:bg-gray-50 rounded-lg transition-colors">
                <img src="<?php echo asset(''); ?>${product.image}" alt="${product.name}" class="w-12 h-12 object-cover rounded-md">
                <div class="flex-1">
                    <h3 class="font-medium text-gray-900">${product.name}</h3>
                    <p class="text-sm text-gray-600">${product.category}</p>
                </div>
                <div class="text-right">
                    <p class="font-medium text-gray-900">₦${(product.price / 100).toFixed(2)}</p>
                </div>
            </a>
        `;
    });
    
    html += '</div>';
    resultsContainer.innerHTML = html;
}

// Close modal when clicking outside
document.getElementById('search-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeSearchModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeSearchModal();
    }
});
</script> 