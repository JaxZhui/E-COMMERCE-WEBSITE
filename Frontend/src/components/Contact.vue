<template>
  <div id="contact" class="contact-form relative overflow-x-hidden w-full min-h-screen">
    <div class="absolute -z-10 w-64 h-64 bg-rose-500 rounded-full opacity-20 top-0 -left-10"></div>
    <div class="absolute -z-10 w-72 h-72 bg-rose-500 rounded-full opacity-20 bottom-0 -right-10"></div>
        
    <h2 class="text-3xl sm:text-5xl font-bold text-center text-black-800 mb-4 sm:mb-8 pt-16 sm:pt-8">Contact Us</h2>
        
    <!-- Success Message -->
    <div v-if="successMessage" class="w-full max-w-md mx-auto mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
        </svg>
        {{ successMessage }}
      </div>
    </div>
    
    <!-- Error Message -->
    <div v-if="errorMessage" class="w-full max-w-md mx-auto mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
      <div class="flex items-center">
        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
        </svg>
        {{ errorMessage }}
      </div>
    </div>
        
    <form @submit.prevent="submitForm" class="w-full max-w-md mx-auto p-4 sm:p-6 bg-white rounded-lg shadow-lg my-3 sm:my-6">
      <div class="mb-3 sm:mb-4">
        <label for="name" class="block text-gray-700 text-lg font-semibold mb-2">Name *</label>
        <input 
          type="text"
          id="name"
          v-model="form.name"
          required
          :disabled="loading"
          :class="[
            'w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors',
            errors.name ? 'border-red-500' : 'border-gray-300'
          ]"
          placeholder="Enter your name"
        >
        <p v-if="errors.name" class="mt-1 text-sm text-red-600">{{ errors.name[0] }}</p>
      </div>
            
      <div class="mb-3 sm:mb-4">
        <label for="email" class="block text-gray-700 text-lg font-semibold mb-2">Email *</label>
        <input 
          type="email"
          id="email"
          v-model="form.email"
          required
          :disabled="loading"
          :class="[
            'w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors',
            errors.email ? 'border-red-500' : 'border-gray-300'
          ]"
          placeholder="Enter your email"
        >
        <p v-if="errors.email" class="mt-1 text-sm text-red-600">{{ errors.email[0] }}</p>
      </div>
            
      <div class="mb-4 sm:mb-6">
        <label for="message" class="block text-gray-700 text-lg font-semibold mb-2">Message *</label>
        <textarea 
          id="message"
          v-model="form.message"
          required
          rows="4"
          :disabled="loading"
          :class="[
            'w-full px-3 py-2 border-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-500 focus:border-transparent transition-colors resize-none',
            errors.message ? 'border-red-500' : 'border-gray-300'
          ]"
          placeholder="Enter your message (minimum 10 characters)"
        ></textarea>
        <p v-if="errors.message" class="mt-1 text-sm text-red-600">{{ errors.message[0] }}</p>
        <p class="mt-1 text-sm text-gray-500">{{ form.message.length }}/1000 characters</p>
      </div>
            
      <button 
        type="submit"
        :disabled="loading || !isFormValid"
        class="w-full bg-rose-500 text-white text-lg font-bold py-3 px-4 rounded-lg hover:bg-rose-600 transition duration-300 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
      >
        <span v-if="loading" class="flex items-center justify-center">
          <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
          Sending...
        </span>
        <span v-else>Send Message</span>
      </button>
    </form>
  </div>
</template>

<script>
import api from '/src/api.js' 

export default {
  name: 'ContactForm',
  data() {
    return {
      form: {
        name: '',
        email: '',
        message: ''
      },
      loading: false,
      successMessage: '',
      errorMessage: '',
      errors: {}
    }
  },
  computed: {
    isFormValid() {
      return this.form.name.trim() !== '' && 
             this.form.email.trim() !== '' && 
             this.form.message.trim().length >= 10
    }
  },
  methods: {
    async submitForm() {
      this.clearMessages()
            
      if (!this.isFormValid) {
        this.errorMessage = 'Please fill in all required fields correctly.'
        return
      }

      this.loading = true
      
      try {
        const response = await api.submitContact({
          name: this.form.name.trim(),
          email: this.form.email.trim(),
          message: this.form.message.trim()
        })

        this.successMessage = response.message || 'Message sent successfully!'
        this.resetForm()
                
        setTimeout(() => {
          this.successMessage = ''
        }, 5000)
        
      } catch (error) {
        if (error.status === 422) {
          this.errors = error.errors || {}
          this.errorMessage = error.message || 'Please check your input and try again.'
        } else if (error.status === 500) {
          this.errorMessage = 'Something went wrong. Please try again later.'
        } else {
          this.errorMessage = error.message || 'An unexpected error occurred. Please try again.'
        }
        
        console.error('Contact form error:', error)
      } finally {
        this.loading = false
      }
    },
        
    resetForm() {
      this.form = {
        name: '',
        email: '',
        message: ''
      }
    },
        
    clearMessages() {
      this.successMessage = ''
      this.errorMessage = ''
      this.errors = {}
    }
  },
    
  // Clear messages when user starts typing
  watch: {
    'form.name'() {
      if (this.errors.name) delete this.errors.name
    },
    'form.email'() {
      if (this.errors.email) delete this.errors.email
    },
    'form.message'() {
      if (this.errors.message) delete this.errors.message
    }
  }
}
</script>

<style scoped>
.contact-form {
  padding: 1rem;
  width: 100%;
  margin: 0 auto;
  min-height: 100vh;
  scroll-margin-top: 4rem;
}

@media (min-width: 640px) {
  .contact-form {
    padding: 2rem;
  }
}

@media (max-width: 639px) {
  .contact-form {
    padding: 1.5rem;
  }
      
  form {
    width: 85%;
    margin: 0 auto;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
}

/* Loading animation */
@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.animate-spin {
  animation: spin 1s linear infinite;
}
</style>
