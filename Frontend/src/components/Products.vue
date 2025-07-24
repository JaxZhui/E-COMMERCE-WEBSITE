<script setup>
import { ref, onMounted, computed } from 'vue'
import { useProductsStore } from '../stores/products.js'

const productsStore = useProductsStore()
const selectedProduct = ref(null)
const showContact = ref(false)

// Use store data and limit to 4 products
const products = computed(() => productsStore.products.slice(0, 4))
const loading = computed(() => productsStore.loading)

const getWhatsAppLink = computed(() => {
  if (selectedProduct.value) {
    const message = `Hello, I'm interested in buying ${selectedProduct.value.name} (ID: ${selectedProduct.value.id}) for Tsh ${selectedProduct.value.price}`;
    return `https://wa.me/+255615819837?text=${encodeURIComponent(message)}`;
  }
  return 'https://wa.me/+255615819837';
})

const getEmailLink = computed(() => {
  if (selectedProduct.value) {
    const subject = `Interest in ${selectedProduct.value.name} (ID: ${selectedProduct.value.id})`;
    const body = `Hello, I'm interested in buying ${selectedProduct.value.name} (ID: ${selectedProduct.value.id}) for Tsh ${selectedProduct.value.price}`;
    return `mailto:fantastchacker@gmail.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
  }
  return 'mailto:fantastchacker@gmail.com';
})

function showDetails(product) {
  selectedProduct.value = product;
  showContact.value = false;
}

function showContactModal(product) {
  selectedProduct.value = product;
  showContact.value = true;
}

function closeContactModal() {
  showContact.value = false;
  selectedProduct.value = null;
}

onMounted(async () => {
  // Fetch data if not already loaded
  if (products.value.length === 0) {
    await productsStore.fetchProducts()
  }
})
</script>

<template>
  <div class="container mx-auto p-4">
    <h1 class="text-5xl font-bold text-black mb-6 text-center">Products</h1>
    
    <!-- Loading State -->
    <div v-if="loading" class="text-center py-8">
      <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-rose-400"></div>
      <p class="mt-2 text-gray-600">Loading products...</p>
    </div>

    <!-- Products Grid -->
    <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
      <div v-for="product in products" :key="product.id" class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="w-full h-48 relative overflow-hidden">
          <img 
            :src="product.image_url || '/src/components/images/placeholder.png'" 
            :alt="product.name" 
            class="w-full h-full object-contain transition duration-300 hover:scale-110"
          >
          <div class="absolute top-2 right-2 flex gap-1">
            <div class="w-3 h-3 rounded-sm bg-rose-400"></div>
            <div class="w-3 h-3 rounded bg-pink-200"></div>
            <div class="w-3 h-3 rotate-45 bg-rose-400"></div>
          </div>
        </div>
        <div class="p-3">
          <h3 class="text-rose-400 font-semibold text-base mb-1">{{ product.name }}</h3>
          <p class="text-black text-sm mb-2">{{ product.description }}</p>
          <div class="flex justify-between items-center">
            <span class="text-rose-400 font-bold text-sm">Tsh {{ product.price }}</span>
            <div class="flex gap-1">
              <button @click="showDetails(product)" class="bg-pink-400 hover:bg-pink-500 text-white px-2 py-1 rounded-md transition duration-300 text-sm">
                Details
              </button>
              <button @click="showContactModal(product)" class="bg-rose-400 hover:bg-rose-500 text-white px-2 py-1 rounded-md transition duration-300 text-sm">
                Buy
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Empty State -->
    <div v-if="!loading && products.length === 0" class="text-center py-8">
      <div class="bg-white rounded-lg p-6 shadow-sm">
        <div class="text-gray-400 mb-4">
          <svg class="w-16 h-16 mx-auto" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 2L3 7v11a1 1 0 001 1h12a1 1 0 001-1V7l-7-5zM10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
          </svg>
        </div>
        <p class="text-gray-500 text-lg">No products available.</p>
      </div>
    </div>

    <!-- Modals remain the same -->
    <!-- Product Details Modal -->
    <div v-if="selectedProduct && !showContact" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-4 rounded-lg max-w-sm w-full">
        <h2 class="text-xl font-bold text-rose-400 mb-3">{{ selectedProduct.name }}</h2>
        <img 
          :src="selectedProduct.image_url || '/src/components/images/placeholder.png'" 
          :alt="selectedProduct.name" 
          class="w-full h-48 object-contain mb-3 rounded"
        >
        <p class="text-black mb-3 text-sm">{{ selectedProduct.description }}</p>
        <p class="text-rose-400 font-bold text-lg mb-3">Tsh {{ selectedProduct.price }}</p>
        <button @click="selectedProduct = null" class="bg-rose-400 hover:bg-rose-500 text-white px-3 py-1.5 rounded-md transition duration-300 text-sm">
          Close
        </button>
      </div>
    </div>

    <!-- Contact Modal -->
    <div v-if="showContact" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-4 rounded-lg max-w-sm w-full">
        <h2 class="text-xl font-bold text-rose-400 mb-3">Contact Us to Buy</h2>
        <div class="space-y-4">
          <a :href="getWhatsAppLink" target="_blank" class="flex items-center gap-2 text-green-600 hover:text-green-700">
            <i class="fas fa-whatsapp text-xl"></i>
            WhatsApp: +255 615 819 837
          </a>
          <a :href="getEmailLink" class="flex items-center gap-2 text-blue-600 hover:text-blue-700">
            <i class="fas fa-envelope text-xl"></i>
            Email: fantastchacker@gmail.com
          </a>
          <a href="tel:+255 713 131 537" class="flex items-center gap-2 text-gray-600 hover:text-gray-700">
            <i class="fas fa-phone text-xl"></i>
            Phone: +255 713 131 537
          </a>
        </div>
        <button @click="closeContactModal" class="mt-4 bg-rose-400 hover:bg-rose-500 text-white px-3 py-1.5 rounded-md transition duration-300 text-sm">
          Close
        </button>
      </div>
    </div>
  </div>
</template>