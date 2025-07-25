const API_BASE_URL = 'http://10.119.27.90:8000/api/v1';

class api {
  async fetchCategories() {
    try {
      const response = await fetch(`${API_BASE_URL}/categories`);
      const data = await response.json();
      return data.success ? data.data : [];
    } catch (error) {
      console.error('Error fetching categories:', error);
      return [];
    }
  }

  async fetchProducts() {
    try {
      const response = await fetch(`${API_BASE_URL}/products`);
      const data = await response.json();
      return data.success ? data.data : [];
    } catch (error) {
      console.error('Error fetching products:', error);
      return [];
    }
  }

  async fetchProductsByCategory(categoryId) {
    try {
      const response = await fetch(`${API_BASE_URL}/products/category/${categoryId}`);
      const data = await response.json();
      return data.success ? data.data : [];
    } catch (error) {
      console.error('Error fetching products by category:', error);
      return [];
    }
  }

  async fetchProduct(id) {
    try {
      const response = await fetch(`${API_BASE_URL}/products/${id}`);
      const data = await response.json();
      return data.success ? data.data : null;
    } catch (error) {
      console.error('Error fetching product:', error);
      return null;
    }
  }

  // Contact API methods
  async submitContact(contactData) {
    try {
      console.log('Submitting contact data:', contactData);
      
      const response = await fetch(`${API_BASE_URL}/contact`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json'
        },
        body: JSON.stringify(contactData)
      });
      
      console.log('Response status:', response.status);
      
      const data = await response.json();
      console.log('Response data:', data);
      
      if (!response.ok) {
        const error = {
          status: response.status,
          message: data.message || 'An error occurred while submitting the form',
          details: data
        };
        
        if (response.status === 422) {
          error.errors = data.errors || {};
          error.message = data.message || 'Validation failed';
        }
        
        throw error;
      }
      
      return data;
    } catch (error) {
      console.error('Error submitting contact form:', error);
      
      if (error.status) {
        throw error;
      }
      
      throw {
        status: error.name === 'TypeError' ? 503 : 500,
        message: error.name === 'TypeError' ? 
          'Service temporarily unavailable. Please try again later.' : 
          'Something went wrong. Please try again later.',
        details: error
      };
    }
  }

  async fetchContacts() {
    try {
      const response = await fetch(`${API_BASE_URL}/contacts`);
      const data = await response.json();
      return data.success ? data.data : [];
    } catch (error) {
      console.error('Error fetching contacts:', error);
      return [];
    }
  }

  async fetchContact(id) {
    try {
      const response = await fetch(`${API_BASE_URL}/contacts/${id}`);
      const data = await response.json();
      return data.success ? data.data : null;
    } catch (error) {
      console.error('Error fetching contact:', error);
      return null;
    }
  }
}

export default new api();
