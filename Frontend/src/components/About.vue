<template>
  <div class="min-h-screen relative overflow-visible bg-white">
    <div class="container mx-auto px-4 py-8 sm:py-16 relative z-10" id="about">
      <!-- Header Section -->
      <div class="text-center mb-8 sm:mb-16" data-aos="fade-down" data-aos-offset="200" data-aos-once="false">
        <h1 class="text-3xl sm:text-4xl font-bold text-rose-600 mb-4">About Our Business</h1>
        <div class="w-24 h-1 bg-pink-400 mx-auto"></div>
      </div>

      <!-- Background particles and shapes -->
      <div class="absolute inset-0 z-0">
        <div class="absolute w-4 h-4 bg-rose-400 rounded-full animate-float" style="top: 10%; left: 20%"></div>
        <div class="absolute w-2 h-2 bg-pink-300 rounded-sm animate-float" style="top: 15%; left: 40%"></div>
        <div class="absolute w-6 h-6 border-2 border-rose-200 rounded-full animate-float" style="top: 25%; left: 60%"></div>
        <div class="absolute w-3 h-3 bg-pink-100 rotate-45 animate-float" style="top: 45%; left: 15%"></div>
        <div class="absolute w-8 h-8 border border-rose-600 rounded-lg animate-float" style="top: 65%; left: 75%"></div>
        <div class="absolute w-5 h-5 bg-pink-300 rounded-full animate-float" style="top: 85%; left: 35%"></div>
        <div class="absolute w-3 h-3 border-2 border-rose-200 rotate-12 animate-float" style="top: 30%; left: 85%"></div>
        <div class="absolute w-2 h-2 bg-pink-900 rounded-full animate-float" style="top: 70%; left: 25%"></div>
        <div class="absolute w-4 h-4 border border-rose-200 rounded-sm animate-float" style="top: 55%; left: 90%"></div>
        <div class="absolute w-6 h-6 bg-pink-100 rounded-full animate-float" style="top: 40%; left: 50%"></div>
      </div>

      <!-- Matrix Grid -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-8 mb-8 sm:mb-16">
        <div class="relative bg-white rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-offset="200" data-aos-once="false" data-aos-delay="100">
          <div class="absolute -top-3 -left-3 w-6 h-6 bg-rose-500 rounded-full"></div>
          <h3 class="text-xl sm:text-2xl font-semibold text-rose-600 mb-4">Our Vision</h3>
          <p class="text-gray-600">Transforming ideas into reality with innovative solutions.</p>
        </div>

        <div class="relative bg-white rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-offset="200" data-aos-once="false" data-aos-delay="200">
          <div class="absolute -top-3 -right-3 w-6 h-6 bg-pink-400 rounded-full"></div>
          <h3 class="text-xl sm:text-2xl font-semibold text-pink-500 mb-4">Our Mission</h3>
          <p class="text-gray-600">Delivering excellence through creativity and dedication.</p>
        </div>

        <div class="relative bg-white rounded-lg shadow-lg p-4 sm:p-6" data-aos="fade-up" data-aos-offset="200" data-aos-once="false" data-aos-delay="300">
          <div class="absolute -bottom-3 -right-3 w-6 h-6 bg-rose-400 rounded-full"></div>
          <h3 class="text-xl sm:text-2xl font-semibold text-rose-500 mb-4">Our Values</h3>
          <p class="text-gray-600">Building trust through integrity and innovation.</p>
        </div>
      </div>

      <!-- Decorative Shapes -->
      <div class="relative">
        <div class="absolute top-0 left-0 w-12 sm:w-20 h-12 sm:h-20 border-2 border-rose-200 rounded-full" data-aos="zoom-in" data-aos-offset="200" data-aos-once="false"></div>
        <div class="absolute bottom-0 right-0 w-20 sm:w-32 h-20 sm:h-32 border-2 border-pink-200 rounded-full" data-aos="zoom-in" data-aos-offset="200" data-aos-once="false"></div>
        
        <!-- Content Section -->
        <div class="bg-white rounded-xl p-4 sm:p-8 relative z-10" data-aos="fade-up" data-aos-offset="200" data-aos-once="false">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-8">
            <div>
              <h2 class="text-2xl sm:text-3xl font-bold text-rose-600 mb-4 sm:mb-6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="inline-block mr-2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>Our Location</h2>
              <p class="text-gray-600 mb-4">We are located in Tanzania, with our main offices in Dodoma (Capital City) and a branch office in Mwanza at Saba Saba area. We serve customers across these regions with dedication and excellence.</p>
              <div class="flex space-x-2">
                <div class="w-3 h-3 bg-rose-400 rounded-full"></div>
                <div class="w-3 h-3 bg-pink-400 rounded-full"></div>
                <div class="w-3 h-3 bg-rose-300 rounded-full"></div>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-2 sm:gap-4">
              <div class="bg-rose-50 p-3 sm:p-4 rounded-lg" data-aos="flip-left" data-aos-offset="200" data-aos-once="false">
                <h4 class="text-rose-600 font-semibold">100+</h4>
                <p class="text-xs sm:text-sm text-gray-600">Projects Completed</p>
              </div>
              <div class="bg-pink-50 p-3 sm:p-4 rounded-lg" data-aos="flip-right" data-aos-offset="200" data-aos-once="false">
                <h4 class="text-pink-600 font-semibold">50+</h4>
                <p class="text-xs sm:text-sm text-gray-600">Happy Clients</p>
              </div>
              <div class="bg-rose-50 p-3 sm:p-4 rounded-lg" data-aos="flip-left" data-aos-offset="200" data-aos-once="false">
                <h4 class="text-rose-600 font-semibold">10+</h4>
                <p class="text-xs sm:text-sm text-gray-600">Years Experience</p>
              </div>
              <div class="bg-pink-50 p-3 sm:p-4 rounded-lg" data-aos="flip-right" data-aos-offset="200" data-aos-once="false">
                <h4 class="text-pink-600 font-semibold">24/7</h4>
                <p class="text-xs sm:text-sm text-gray-600">Support</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import AOS from 'aos'
import 'aos/dist/aos.css'

export default {
  name: 'About',
  mounted() {
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: false,
      offset: 200
    })
  }
}
</script>

<style scoped>
.container {
  max-width: 1200px;
  width: 100%;
  min-height: 100vh;
  scroll-margin-top: 80px;
  overflow: visible;
}

@keyframes float {
  0% {
    transform: translateY(0) rotate(0);
  }
  50% {
    transform: translateY(-20px) rotate(5deg);
  }
  100% {
    transform: translateY(0) rotate(0);
  }
}

.animate-float {
  animation: float 8s ease-in-out infinite;
}

@media (max-width: 640px) {
  .container {
    padding-bottom: 2rem;
  }
}
</style>
