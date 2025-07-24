<script setup>
import { RouterLink, useRouter, useRoute } from 'vue-router'
import { ref, onMounted, onUnmounted, watch, computed } from 'vue'
import { useProductsStore } from '/src/stores/products.js'

const router = useRouter()
const route = useRoute()
const productsStore = useProductsStore()
const showMobileCategories = ref(false)
const activeSection = ref('Homie') // Default active section

// Get categories from store
const categories = computed(() => productsStore.categories)

// Function to handle home navigation
const goToHome = () => {
  if (route.path !== '/') {
    router.push('/')
  } else {
    scrollToSection('Homie')
  }
  showMobileCategories.value = false
}

// Function to handle mobile categories navigation
const goToCategories = () => {
  router.push('/Category')
  showMobileCategories.value = false
}

// Function to handle smooth scrolling (only works on home page)
const scrollToSection = (sectionId) => {
  if (route.path !== '/') {
    router.push('/').then(() => {
      setTimeout(() => {
        const element = document.getElementById(sectionId)
        if (element) {
          element.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          })
        }
      }, 100)
    })
  } else {
    const element = document.getElementById(sectionId)
    if (element) {
      element.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      })
    }
  }
  showMobileCategories.value = false
}

// Function to check which section is currently in view (only on home page)
const checkActiveSection = () => {
  if (route.path !== '/') {
    activeSection.value = ''
    return
  }
  const sections = ['Homie', 'Products', 'About', 'contact']
  const scrollPosition = window.scrollY + 100

  for (let i = sections.length - 1; i >= 0; i--) {
    const section = document.getElementById(sections[i])
    if (section && section.offsetTop <= scrollPosition) {
      activeSection.value = sections[i]
      break
    }
  }
}

// Set up scroll listener
onMounted(async () => {
  window.addEventListener('scroll', checkActiveSection)
  checkActiveSection()
  
  // Fetch categories when component mounts
  if (categories.value.length === 0) {
    await productsStore.fetchCategories()
  }
})

onUnmounted(() => {
  window.removeEventListener('scroll', checkActiveSection)
})

// Watch for route changes to update active section
watch(() => route.path, () => {
  checkActiveSection()
})

// Helper function to check if a section is active
const isActive = (sectionId) => {
  return route.path === '/' && activeSection.value === sectionId
}

// Helper function to check if category is active
const isCategoryActive = (categorySlug) => {
  return route.path === `/category/${categorySlug}`
}
</script>

<template>
  <nav>
    <!-- Desktop Navigation -->
    <div class="hidden md:block fixed top-0 w-full bg-white z-50">
      <div class="max-w-7xl mx-auto px-8 py-4 flex justify-between items-center">
        <button @click="goToHome" class="flex items-center text-rose-500 text-3xl font-bold no-underline cursor-pointer">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="currentColor">
            <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
          </svg>
          <span>EShop</span>
        </button>

        <div class="absolute left-1/2 transform -translate-x-1/2 flex items-center space-x-8">
          <button 
            @click="goToHome"
            class="flex items-center font-medium relative group text-lg cursor-pointer transition-colors duration-300"
            :class="isActive('Homie') ? 'text-rose-500' : 'text-gray-700 hover:text-rose-500'"
          >
            <span>Home</span>
            <div 
              class="absolute bottom-0 left-0 h-0.5 bg-rose-500 transition-all duration-300"
              :class="isActive('Homie') ? 'w-full' : 'w-0 group-hover:w-full'"
            ></div>
          </button>

          <!-- Dynamic Categories Dropdown -->
          <div class="relative group">
            <div class="flex items-center text-gray-700 hover:text-rose-500 font-medium cursor-pointer text-lg">
              <span>Categories</span>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                <path d="M7 10l5 5 5-5z"/>
              </svg>
            </div>
            <div class="hidden group-hover:block absolute top-full left-0 w-56 bg-white rounded-md py-2 shadow-lg">
              <!-- All Categories Link -->
              <router-link to="/Category" class="block px-6 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-500 text-base">
                All Categories
              </router-link>
              <!-- Dynamic Categories from API -->
              <router-link 
                v-for="category in categories" 
                :key="category.id"
                :to="`/category/${category.slug}`" 
                class="block px-6 py-2 text-gray-700 hover:bg-gray-50 hover:text-rose-500 text-base"
              >
                {{ category.name }}
              </router-link>
            </div>
          </div>

          <button 
            @click="scrollToSection('About')"
            class="flex items-center font-medium relative group text-lg cursor-pointer transition-colors duration-300"
            :class="isActive('About') ? 'text-rose-500' : 'text-gray-700 hover:text-rose-500'"
          >
            <span>About Us</span>
            <div 
              class="absolute bottom-0 left-0 h-0.5 bg-rose-500 transition-all duration-300"
              :class="isActive('About') ? 'w-full' : 'w-0 group-hover:w-full'"
            ></div>
          </button>

          <button 
            @click="scrollToSection('contact')"
            class="flex items-center font-medium relative group text-lg cursor-pointer transition-colors duration-300"
            :class="isActive('contact') ? 'text-rose-500' : 'text-gray-700 hover:text-rose-500'"
          >
            <span>Contact</span>
            <div 
              class="absolute bottom-0 left-0 h-0.5 bg-rose-500 transition-all duration-300"
              :class="isActive('contact') ? 'w-full' : 'w-0 group-hover:w-full'"
            ></div>
          </button>
        </div>
        
        <div class="flex items-center space-x-6">
          <div class="flex flex-col items-center">
            <span class="text-gray-700 font-medium text-sm uppercase tracking-wide">Call Us Now</span>
            <a href="tel:+255713131537" class="text-rose-500 font-bold text-lg hover:text-rose-600 transition-colors duration-300">+255 713 131 537</a>
          </div>
        </div>
      </div>
    </div>

    <!-- Mobile Header and Bottom Navigation -->
    <div class="md:hidden">
      <!-- Mobile Header -->
      <div class="fixed top-0 left-0 right-0 bg-white z-50">
        <div class="flex justify-between items-center px-6 py-4">
          <button @click="goToHome" class="flex items-center text-rose-500 text-xl font-bold no-underline cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
              <path d="M20 4H4v2h16V4zm1 10v-2l-1-5H4l-1 5v2h1v6h10v-6h4v6h2v-6h1zm-9 4H6v-4h6v4z"/>
            </svg>
            <span class="ml-2">EShop</span>
          </button>
          <div class="flex flex-col">
            <span class="text-gray-700 text-sm font-medium uppercase">Call Us Now</span>
            <a href="tel:+255713131537" class="text-rose-500 font-bold text-base">+255 713 131 537</a>
          </div>
        </div>
        
        <!-- Mobile Category Sub-Navigation -->
        <div class="bg-gray-50 border-t border-gray-200 px-4 py-3">
          <div class="flex space-x-1 overflow-x-auto scrollbar-hide">
            <!-- All Categories -->
            <router-link 
              to="/Category"
              class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300"
              :class="route.path === '/Category' ? 'bg-rose-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-rose-100 hover:text-rose-600'"
            >
              All Categories
            </router-link>

            <!-- Dynamic Categories from API -->
            <router-link 
              v-for="category in categories"
              :key="category.id"
              :to="`/category/${category.slug}`"
              class="flex-shrink-0 px-4 py-2 rounded-full text-sm font-medium transition-all duration-300"
              :class="isCategoryActive(category.slug) ? 'bg-rose-500 text-white shadow-md' : 'bg-white text-gray-700 hover:bg-rose-100 hover:text-rose-600'"
            >
              {{ category.name }}
            </router-link>
          </div>
        </div>

        <!-- Mobile Categories Dropdown (if you still want this) -->
        <div v-if="showMobileCategories" class="bg-white border-t border-gray-100">
          <router-link 
            to="/Category"
            class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-rose-500 border-b border-gray-50 text-base"
            @click="showMobileCategories = false"
          >
            All Categories
          </router-link>
          <router-link 
            v-for="category in categories"
            :key="category.id"
            :to="`/category/${category.slug}`"
            class="block px-6 py-3 text-gray-700 hover:bg-gray-50 hover:text-rose-500 border-b border-gray-50 text-base"
            @click="showMobileCategories = false"
          >
            {{ category.name }}
          </router-link>
        </div>
      </div>

      <!-- Mobile Bottom Navigation -->
      <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-50">
        <div class="flex justify-around items-center py-3">
          <!-- Home -->
          <button 
            @click="goToHome"
            class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-300 transform hover:scale-110"
            :class="route.path === '/' && isActive('Homie') ? 'text-rose-500 bg-rose-100' : route.path === '/' ? 'text-gray-600 hover:text-rose-500 hover:bg-rose-50' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50'"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="transition-transform duration-300 hover:rotate-6">
              <path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/>
            </svg>
            <span class="text-sm mt-1 font-semibold tracking-wide">Home</span>
          </button>

          <!-- Categories -->
          <button 
            @click="goToCategories"
            class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-300 transform hover:scale-110"
            :class="route.path === '/Category' || route.path.startsWith('/category/') ? 'text-rose-500 bg-rose-100' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50'"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="transition-transform duration-300 hover:rotate-6">
              <path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/>
            </svg>
            <span class="text-sm mt-1 font-semibold tracking-wide">Categories</span>
          </button>

          <!-- About -->
          <button 
            @click="scrollToSection('About')"
            class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-300 transform hover:scale-110"
            :class="isActive('About') ? 'text-rose-500 bg-rose-100' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50'"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="transition-transform duration-300 hover:rotate-6">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
            </svg>
                     <span class="text-sm mt-1 font-semibold tracking-wide">About</span>
          </button>

          <!-- Contact -->
          <button 
            @click="scrollToSection('contact')"
            class="flex flex-col items-center py-2 px-4 rounded-xl transition-all duration-300 transform hover:scale-110"
            :class="isActive('contact') ? 'text-rose-500 bg-rose-100' : 'text-gray-600 hover:text-rose-500 hover:bg-rose-50'"
          >
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="transition-transform duration-300 hover:rotate-6">
              <path d="M20 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
            </svg>
            <span class="text-sm mt-1 font-semibold tracking-wide">Contact</span>
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.hover-line::after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: rgb(251 113 133);
  transition: width 0.2s ease-in-out;
}

.hover-line:hover::after {
  width: 100%;
}

@media (max-width: 1024px) {
  .hover-line::after {
    display: none;
  }
}

/* Hide scrollbar for mobile category navigation */
.scrollbar-hide {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

.scrollbar-hide::-webkit-scrollbar {
  display: none;
}

/* Smooth scrolling for the entire page */
html {
  scroll-behavior: smooth;
}
</style>
