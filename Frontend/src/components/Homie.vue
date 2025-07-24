<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import AOS from 'aos';
import 'aos/dist/aos.css';
import Nav from '/src/components/Navbar/Nav.vue';
import Hphone from '/src/components/images/Hphone.png';
import Shirt1 from '/src/components/images/Shirt1.png';
import Shirt2 from '/src/components/images/Shirt2.png';
import Shoes from '/src/components/images/Shoes.png';
// Image slider setup
const images = [Shirt1, Hphone, Shirt2, Shoes];
const currentIndex = ref(0);
let slideInterval = null;

// Auto-slide functionality
const startAutoSlide = () => {
  slideInterval = setInterval(() => {
    currentIndex.value = (currentIndex.value + 1) % images.length;
  }, 3000);
};

const stopAutoSlide = () => {
  if (slideInterval) {
    clearInterval(slideInterval);
    slideInterval = null;
  }
};

// Navigation functions
const nextSlide = () => {
  currentIndex.value = (currentIndex.value + 1) % images.length;
};

const prevSlide = () => {
  currentIndex.value = currentIndex.value === 0 ? images.length - 1 : currentIndex.value - 1;
};

const goToSlide = (index) => {
  currentIndex.value = index;
};

onMounted(() => {
  // Initialize AOS
  AOS.init({
    duration: 1000,
    easing: 'ease-in-out',
    once: true,
    offset: 100
  });
  
  startAutoSlide();
});

onUnmounted(() => {
  stopAutoSlide();
});
</script>

<template>
    <div>
        <header class="fixed w-full top-0 z-50">
            <Nav />
        </header>
        <div class="pt-16 overflow-x-hidden">
            <div id="home" class="min-h-screen py-4 sm:py-8 px-2 sm:px-4 relative overflow-hidden">
                <!-- Mobile Layout -->
                <div class="block lg:hidden">
                    <!-- Mobile Hero Content -->
                    <div class="flex flex-col items-center text-center mt-8 mb-8 px-4">
                        <h2 
                            class="text-2xl sm:text-3xl font-light text-gray-800 tracking-wider mb-2"
                            data-aos="fade-down"
                            data-aos-delay="100"
                        >
                            New arrivals
                        </h2>
                        <p 
                            class="text-3xl sm:text-4xl font-extrabold mb-1"
                            data-aos="fade-right"
                            data-aos-delay="300"
                        >
                            JUST FOR
                        </p>
                        <p 
                            class="text-3xl sm:text-4xl font-extrabold text-black mb-4"
                            data-aos="fade-left"
                            data-aos-delay="500"
                        >
                            YOU
                        </p>
                                                
                        <!-- Mobile Discount Badge -->
                        <div 
                            class="bg-rose-500 text-white rounded-2xl px-6 py-4 mb-6 shadow-lg"
                            data-aos="zoom-in"
                            data-aos-delay="700"
                        >
                            <p class="text-3xl sm:text-4xl font-extrabold leading-tight">30%</p>
                            <p class="text-3xl sm:text-4xl font-bold leading-none">OFF</p>
                        </div>
                                                
                        <div>
                            <p class="text-lg sm:text-xl font-semibold text-rose-500 bg-rose-100 rounded-full px-6 py-3 hover:shadow-md transition-shadow duration-300 cursor-pointer">
                                Shop Now
                            </p>
                        </div>
                    </div>
                    <!-- Mobile Image Slider -->
                    <div class="flex justify-center mb-8">
                        <div class="relative w-72 h-72 sm:w-80 sm:h-80 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-2xl"
                             @mouseenter="stopAutoSlide"
                             @mouseleave="startAutoSlide">
                                                        
                            <!-- Background bubble -->
                            <div class="w-full h-full bg-rose-500 rounded-full opacity-20 absolute inset-0"></div>
                                                        
                            <!-- Images -->
                            <div class="relative w-full h-full">
                                <div v-for="(image, index) in images"
                                     :key="index"
                                     class="absolute inset-0 transition-all duration-700 ease-in-out transform"
                                     :class="{
                                         'opacity-100 scale-100': currentIndex === index,
                                         'opacity-0 scale-110': currentIndex !== index
                                     }">
                                    <img :src="image"
                                         :alt="`Product ${index + 1}`"
                                         class="w-full h-full object-contain p-6 filter drop-shadow-2xl" />
                                </div>
                            </div>
                                                        
                            <!-- Mobile Navigation arrows -->
                            <button @click="prevSlide"
                                    class="absolute left-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-2 transition-all duration-300 group">
                                <svg class="w-5 h-5 text-white group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                                                        
                            <button @click="nextSlide"
                                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-2 transition-all duration-300 group">
                                <svg class="w-5 h-5 text-white group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                                                        
                            <!-- Mobile Dot indicators -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                                <button v-for="(_, index) in images"
                                        :key="index"
                                        @click="goToSlide(index)"
                                        class="w-2.5 h-2.5 rounded-full transition-all duration-300 border-2"
                                        :class="{
                                            'bg-white border-white scale-110': currentIndex === index,
                                            'bg-transparent border-white/50 hover:border-white': currentIndex !== index
                                        }">
                                </button>
                            </div>
                                                        
                            <!-- Mobile Slide counter -->
                            <div class="absolute top-4 right-4 bg-black/20 backdrop-blur-sm rounded-full px-2 py-1">
                                <span class="text-white text-xs font-medium">
                                    {{ currentIndex + 1 }} / {{ images.length }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Mobile Info Cards -->
                    <div class="flex flex-col space-y-4 px-4 mb-8">
                        <!-- Location Card -->
                         



                         
                        <!-- Online Orders Card -->
                        <div 
                            class="bg-white shadow-lg rounded-lg p-4 w-full"
                            data-aos="slide-up"
                            data-aos-delay="1100"
                        >
                            <p class="text-sm font-bold text-gray-800">FOR</p>
                            <p class="text-xl font-extrabold text-black">ONLINE</p>
                            <p class="text-sm font-semibold text-gray-600">ORDERS</p>
                            <div class="w-full h-0.5 bg-black mt-2"></div>
                        </div>
                    </div>
                    <!-- Mobile Social Media Icons -->
                    <div class="flex justify-center space-x-6 mb-8">
                        <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300 p-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300 p-2">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300 p-2">
                                                      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                            </svg>
                        </a>
                    </div>
                    <!-- Mobile Decorative Shapes -->
                    <div class="absolute inset-0 pointer-events-none overflow-hidden">
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute top-20 left-4"></div>
                        <div class="w-3 h-3 bg-rose-400 opacity-25 transform rotate-45 absolute top-32 right-6"></div>
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute bottom-32 left-8"></div>
                        <div class="w-3 h-3 bg-rose-500 opacity-25 transform rotate-45 absolute bottom-20 right-4"></div>
                    </div>
                </div>
                <!-- Desktop Layout (hidden on mobile) -->
                <div class="hidden lg:block">
                    <div class="flex flex-col items-start ml-4 md:ml-16 mt-20">
                        <h2 
                            class="text-4xl font-light text-gray-800 tracking-wider mb-2"
                            data-aos="fade-down"
                            data-aos-delay="100"
                        >
                            New arrivals
                        </h2>
                        <p 
                            class="text-4xl md:text-6xl font-extrabold mb-2"
                            data-aos="fade-right"
                            data-aos-delay="300"
                        >
                            JUST FOR
                        </p>
                        <p 
                            class="text-4xl md:text-6xl font-extrabold text-black mb-6"
                            data-aos="fade-left"
                            data-aos-delay="500"
                        >
                            YOU
                        </p>
                        <div>
                            <p class="text-xl md:text-2xl font-semibold text-rose-500 bg-rose-100 rounded-full px-6 py-2 hover:shadow-md transition-shadow duration-300 cursor-pointer">
                                Shop Now
                            </p>
                        </div>
                        <!-- Matrix shapes -->
                        <div class="w-3 h-3 bg-rose-500 opacity-25 transform rotate-45 absolute top-20 left-0"></div>
                        <div class="w-2 h-2 bg-rose-400 opacity-20 transform rotate-45 absolute top-32 left-8"></div>
                        <div class="w-4 h-4 bg-rose-500 opacity-30 transform rotate-45 absolute top-48 left-16"></div>
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute top-24 left-24"></div>
                        <div class="w-3 h-3 bg-rose-500 opacity-25 transform rotate-45 absolute bottom-20 left-4"></div>
                        <div class="w-4 h-4 bg-rose-400 opacity-30 transform rotate-45 absolute bottom-32 left-20"></div>
                    </div>
                                        
                    <!-- Center bubble with image slider -->
                    <div class="absolute left-1/2 top-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20">
                        <!-- Background bubble -->
                        <div class="w-80 h-80 md:w-96 md:h-96 bg-rose-500 rounded-full opacity-20 absolute inset-0"></div>
                                                
                        <!-- Image slider container -->
                        <div class="relative w-80 h-80 md:w-96 md:h-96 rounded-full overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20"
                             @mouseenter="stopAutoSlide"
                             @mouseleave="startAutoSlide">
                                                        
                            <!-- Images -->
                            <div class="relative w-full h-full">
                                <div v-for="(image, index) in images"
                                     :key="index"
                                     class="absolute inset-0 transition-all duration-700 ease-in-out transform"
                                     :class="{
                                         'opacity-100 scale-100': currentIndex === index,
                                         'opacity-0 scale-110': currentIndex !== index
                                     }">
                                    <img :src="image"
                                         :alt="`Product ${index + 1}`"
                                         class="w-full h-full object-contain p-8 filter drop-shadow-2xl" />
                                </div>
                            </div>
                                                        
                            <!-- Navigation arrows -->
                            <button @click="prevSlide"
                                    class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-2 transition-all duration-300 group">
                                <svg class="w-6 h-6 text-white group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                                                        
                            <button @click="nextSlide"
                                    class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-full p-2 transition-all duration-300 group">
                                <svg class="w-6 h-6 text-white group-hover:text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                                                        
                            <!-- Dot indicators -->
                            <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 flex space-x-3">
                                <button v-for="(_, index) in images"
                                        :key="index"
                                        @click="goToSlide(index)"
                                        class="w-3 h-3 rounded-full transition-all duration-300 border-2"
                                        :class="{
                                            'bg-white border-white scale-110': currentIndex === index,
                                            'bg-transparent border-white/50 hover:border-white': currentIndex !== index
                                        }">
                                </button>
                            </div>
                                                        
                            <!-- Slide counter -->
                            <div class="absolute top-6 right-6 bg-black/20 backdrop-blur-sm rounded-full px-3 py-1">
                                <span class="text-white text-sm font-medium">
                                    {{ currentIndex + 1 }} / {{ images.length }}
                                </span>
                            </div>
                        </div>
                    </div>
                                        
                    <!-- Fixed positioning for right side content -->
                    <div class="absolute right-4 md:right-20 lg:right-40 top-40 z-10">
                        <p 
                            class="text-sm md:text-base font-bold text-gray-800"
                            data-aos="fade-left"
                            data-aos-delay="400"
                        >
                            FOR
                        </p>
                        <p 
                            class="text-2xl md:text-3xl font-extrabold text-black"
                            data-aos="fade-left"
                            data-aos-delay="500"
                        >
                            ONLINE
                        </p>
                        <p 
                            class="text-sm md:text-base font-semibold text-gray-600"
                            data-aos="fade-left"
                            data-aos-delay="600"
                        >
                            ORDERS
                        </p>
                        <div class="w-32 md:w-40 h-0.5 bg-black mt-2 font-bold"></div>
                        <!-- Matrix shapes -->
                        <div class="w-3 h-3 bg-rose-500 opacity-25 transform rotate-45 absolute -top-8 right-4"></div>
                        <div class="w-2 h-2 bg-rose-400 opacity-20 transform rotate-45 absolute -top-4 right-12"></div>
                        <div class="w-4 h-4 bg-rose-500 opacity-30 transform rotate-45 absolute top-20 -right-8"></div>
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute top-16 right-4"></div>
                    </div>
                                        
                    <!-- Fixed shape positioning -->
                    <div class="absolute -right-20 md:-right-32 lg:-right-40 top-40">
                        <div class="w-72 h-72 md:w-96 md:h-96 bg-rose-500 opacity-20 transform rotate-45 skew-x-12"></div>
                        <div class="w-4 h-4 bg-rose-500 opacity-30 transform rotate-45 absolute top-12 -left-20"></div>
                        <div class="w-3 h-3 bg-rose-500 opacity-25 transform rotate-45 absolute top-32 -left-8"></div>
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute top-48 -left-32"></div>
                        <div class="w-4 h-4 bg-rose-500 opacity-30 transform rotate-45 absolute bottom-24 -right-16"></div>
                        <div class="w-3 h-3 bg-rose-400 opacity-25 transform rotate-45 absolute bottom-40 -right-28"></div>
                        <div class="w-2 h-2 bg-rose-500 opacity-20 transform rotate-45 absolute bottom-8 -right-36"></div>
                    </div>
                                        
                    <!-- Fixed discount text positioning -->
                    <div class="absolute right-4 md:right-20 lg:right-40 top-[280px] z-10">
                        <p 
                            class="text-5xl md:text-7xl font-extrabold text-rose-500 leading-tight"
                            data-aos="zoom-in"
                            data-aos-delay="1000"
                        >
                            30%
                        </p>
                        <p 
                            class="text-5xl md:text-7xl font-bold text-rose-500 leading-none"
                            data-aos="zoom-in"
                            data-aos-delay="1100"
                        >
                                                  OFF
                        </p>
                        <div class="w-32 md:w-40 h-0.5 bg-black mt-2"></div>
                    </div>
                                        
                    <div class="absolute bottom-20 left-4 md:left-10">
                        <div 
                            class="bg-white shadow-lg rounded-lg p-4 w-56 md:w-64"
                            data-aos="slide-up"
                            data-aos-delay="1200"
                        >
                            <div class="flex items-center mb-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-rose-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="ml-2 font-semibold text-gray-800">Dar es Salaam</span>
                            </div>
                            <div class="text-sm text-gray-600">
                                <p>Mikocheni</p>
                                <p>Tabata</p>
                            </div>
                        </div>
                    </div>
                                        
                    <!-- Social Media Icons -->
                    <div class="absolute bottom-20 right-8 md:right-14">
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-600 hover:text-rose-500 transition-colors duration-300">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678c-3.405 0-6.162 2.76-6.162 6.162 0 3.405 2.76 6.162 6.162 6.162 3.405 0 6.162-2.76 6.162-6.162 0-3.405-2.76-6.162-6.162-6.162zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405c0 .795-.646 1.44-1.44 1.44-.795 0-1.44-.646-1.44-1.44 0-.794.646-1.439 1.44-1.439.793-.001 1.44.645 1.44 1.439z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
