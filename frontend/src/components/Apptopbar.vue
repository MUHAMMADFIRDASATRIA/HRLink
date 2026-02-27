<template>
  <header class="topbar">
    <div class="search-bar">
      <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      <input type="text" placeholder="Search..." v-model="searchQuery" />
      <div class="search-chevron">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#aaa" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
    </div>

    <div class="topbar-user">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <span class="user-label">{{ username }}</span>
      <div class="avatar">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="#fff"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'

defineProps({
  username: {
    type: String,
    default: 'Admin (HRD)',
  },
})

const searchQuery = ref('')
</script>

<style scoped>
* { box-sizing: border-box; margin: 0; padding: 0; }

.topbar {
  height: 60px;
  background: #fff;
  border-bottom: 1px solid #ebebeb;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 28px;
  flex-shrink: 0;
}

.search-bar {
  display: flex;
  align-items: center;
  gap: 10px;
  background: #f7f7f9;
  border: 1px solid #ebebeb;
  border-radius: 10px;
  padding: 8px 14px;
  width: 420px;
}

.search-bar input {
  border: none;
  background: none;
  outline: none;
  font-size: 13px;
  color: #555;
  flex: 1;
  font-family: 'Segoe UI', sans-serif;
}

.search-bar input::placeholder { color: #bbb; }

.search-chevron { margin-left: auto; }

.topbar-user {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
}

.user-label {
  font-size: 13.5px;
  color: #444;
  font-weight: 500;
}

.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: linear-gradient(135deg, #4db89e, #2e7d5e);
  display: flex;
  align-items: center;
  justify-content: center;
}
</style>