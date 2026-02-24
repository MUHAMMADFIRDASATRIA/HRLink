<!-- filepath: src/App.vue -->
<template>
  <div>
    <h1>Laravel API Test</h1>
    <div v-if="loading">Loading...</div>
    <div v-else>
      <pre>{{ apiData }}</pre>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const apiData = ref(null)
const loading = ref(true)

onMounted(async () => {
  try {
    const res = await fetch('http://127.0.0.1:8000/api/health')
    apiData.value = await res.json()
  } catch (e) {
    apiData.value = 'Gagal fetch API'
  } finally {
    loading.value = false
  }
})
</script>