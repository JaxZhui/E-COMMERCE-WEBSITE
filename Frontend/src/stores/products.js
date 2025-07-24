import { defineStore } from 'pinia'
import api from '/src/api.js'

export const useProductsStore = defineStore('products', {
  state: () => ({
    products: [],
    categories: [],
    loading: false,
    error: null
  }),

  getters: {
    getProductsByCategory: (state) => (categoryId) => {
      if (!categoryId) return state.products
      return state.products.filter(product => product.category_id === categoryId)
    },
    
    getProductById: (state) => (id) => {
      return state.products.find(product => product.id === id)
    },
    
    getCategoryBySlug: (state) => (slug) => {
      return state.categories.find(category => category.slug === slug)
    }
  },

  actions: {
    async fetchProducts() {
      this.loading = true
      this.error = null
      try {
        this.products = await api.fetchProducts()
      } catch (error) {
        this.error = 'Failed to fetch products'
        console.error('Error fetching products:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchCategories() {
      this.loading = true
      this.error = null
      try {
        this.categories = await api.fetchCategories()
      } catch (error) {
        this.error = 'Failed to fetch categories'
        console.error('Error fetching categories:', error)
      } finally {
        this.loading = false
      }
    },

    async fetchProductsByCategory(categoryId) {
      this.loading = true
      this.error = null
      try {
        const products = await api.fetchProductsByCategory(categoryId)
        return products
      } catch (error) {
        this.error = 'Failed to fetch category products'
        console.error('Error fetching category products:', error)
        return []
      } finally {
        this.loading = false
      }
    },

    async refreshData() {
      await Promise.all([
        this.fetchProducts(),
        this.fetchCategories()
      ])
    }
  }
})
