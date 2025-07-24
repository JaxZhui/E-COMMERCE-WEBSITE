<script setup>
import Homie from '/src/components/Homie.vue';
import Products from '/src/components/Products.vue';
import About from '/src/components/About.vue';
import Contact from '/src/components/Contact.vue';
</script>

<template>
  <div>
    <section id="Homie">
      <div>
        <Homie />
      </div>
    </section>
    
    <section id="products">
      <Products />
    </section>
    
    <section id="About">
      <About />
    </section>
     
    <section id="contact">
      <Contact />
    </section>
  </div>
</template>

<script>
export default {
  name: 'Home',
  components: {
    Homie,
    Products,
    About,
    Contact
  }
}
</script>
