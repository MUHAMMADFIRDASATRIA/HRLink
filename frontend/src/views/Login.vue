<template>
  <div
    class="min-h-screen flex items-center justify-center relative overflow-hidden"
    style="background: linear-gradient(145deg, #b8d8cc 0%, #cce4d8 20%, #daeee5 45%, #e8f3ee 65%, #f2f8f5 100%)"
  >
    <!-- Blur Decorations -->
    <!-- Bottom-right: bright warm white glow -->
    <div
      class="absolute pointer-events-none"
      style="
        width: 900px;
        height: 700px;
        background: radial-gradient(ellipse at center, rgba(255,255,255,0.75) 0%, rgba(220,242,232,0.3) 45%, transparent 75%);
        bottom: -250px;
        right: -200px;
        filter: blur(40px);
      "
    ></div>
    <!-- Top-left: teal darker tone -->
    <div
      class="absolute pointer-events-none"
      style="
        width: 600px;
        height: 500px;
        background: radial-gradient(ellipse at center, rgba(120,180,155,0.3) 0%, transparent 70%);
        top: -150px;
        left: -150px;
        filter: blur(60px);
      "
    ></div>
    <!-- Center-right subtle white bloom -->
    <div
      class="absolute pointer-events-none"
      style="
        width: 500px;
        height: 500px;
        background: radial-gradient(ellipse at center, rgba(255,255,255,0.6) 0%, transparent 70%);
        top: 50%;
        right: -50px;
        transform: translateY(-50%);
        filter: blur(50px);
      "
    ></div>

    <!-- Card -->
    <div
      class="relative w-full"
      style="
        max-width: 420px;
        background: rgba(255,255,255,0.88);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border-radius: 28px;
        padding: 48px 44px 40px;
        box-shadow:
          0 4px 6px rgba(0,0,0,0.03),
          0 20px 60px rgba(0,0,0,0.08),
          0 1px 0 rgba(255,255,255,0.9) inset;
        margin: 24px;
      "
    >
      <!-- Logo -->
      <div style="text-align: center; margin-bottom: 28px;">
        <div
          style="
            width: 64px;
            height: 64px;
            background: linear-gradient(145deg, #3d8b66, #2e6e50);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            box-shadow: 0 8px 24px rgba(46,110,80,0.35);
          "
        >
          <span style="color: #fff; font-size: 28px; font-weight: 700; font-family: 'Segoe UI', sans-serif;">H</span>
        </div>
        <h1
          style="
            margin-top: 18px;
            font-size: 22px;
            font-weight: 700;
            color: #1a2e25;
            font-family: 'Segoe UI', system-ui, sans-serif;
            letter-spacing: -0.3px;
          "
        >HRD Saya</h1>
        <p
          style="
            color: #8a9e94;
            font-size: 13px;
            margin-top: 4px;
            font-family: 'Segoe UI', system-ui, sans-serif;
            letter-spacing: 0.3px;
          "
        >Sistem Monitoring PKWT</p>
      </div>

      <!-- Error Alert -->
      <div
        v-if="errorMessage"
        style="
          display: flex;
          align-items: center;
          gap: 10px;
          background: #fff0f0;
          border: 1px solid #ffd6d6;
          color: #c0392b;
          font-size: 13.5px;
          padding: 12px 16px;
          border-radius: 12px;
          margin-bottom: 20px;
          font-family: 'Segoe UI', system-ui, sans-serif;
        "
      >
        <!-- Error circle icon -->
        <svg width="18" height="18" viewBox="0 0 20 20" fill="none" style="flex-shrink:0">
          <circle cx="10" cy="10" r="10" fill="#e74c3c"/>
          <rect x="9" y="5" width="2" height="6" rx="1" fill="white"/>
          <rect x="9" y="13" width="2" height="2" rx="1" fill="white"/>
        </svg>
        {{ errorMessage }}
      </div>

      <!-- Form -->
      <form @submit.prevent="handleLogin">

        <!-- Email -->
        <div style="margin-bottom: 18px;">
          <label
            style="
              display: block;
              font-size: 13px;
              font-weight: 500;
              color: #5a6b62;
              margin-bottom: 6px;
              font-family: 'Segoe UI', system-ui, sans-serif;
            "
          >Email</label>
          <input
            v-model="email"
            type="email"
            placeholder="admin@example.com"
            required
            style="
              width: 100%;
              padding: 12px 16px;
              border: 1.5px solid #e2ece7;
              border-radius: 12px;
              background: #f7faf8;
              color: #1a2e25;
              font-size: 14px;
              font-family: 'Segoe UI', system-ui, sans-serif;
              outline: none;
              transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
              box-sizing: border-box;
            "
            @focus="e => { e.target.style.borderColor='#3d8b66'; e.target.style.background='#fff'; e.target.style.boxShadow='0 0 0 3px rgba(61,139,102,0.12)' }"
            @blur="e => { e.target.style.borderColor='#e2ece7'; e.target.style.background='#f7faf8'; e.target.style.boxShadow='none' }"
          />
        </div>

        <!-- Password -->
        <div style="margin-bottom: 18px;">
          <label
            style="
              display: block;
              font-size: 13px;
              font-weight: 500;
              color: #5a6b62;
              margin-bottom: 6px;
              font-family: 'Segoe UI', system-ui, sans-serif;
            "
          >Password</label>
          <div style="position: relative;">
            <input
              v-model="password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••••"
              required
              style="
                width: 100%;
                padding: 12px 48px 12px 16px;
                border: 1.5px solid #e2ece7;
                border-radius: 12px;
                background: #f7faf8;
                color: #1a2e25;
                font-size: 14px;
                font-family: 'Segoe UI', system-ui, sans-serif;
                outline: none;
                transition: border-color 0.2s, background 0.2s, box-shadow 0.2s;
                box-sizing: border-box;
              "
              @focus="e => { e.target.style.borderColor='#3d8b66'; e.target.style.background='#fff'; e.target.style.boxShadow='0 0 0 3px rgba(61,139,102,0.12)' }"
              @blur="e => { e.target.style.borderColor='#e2ece7'; e.target.style.background='#f7faf8'; e.target.style.boxShadow='none' }"
            />
            <!-- Eye Toggle -->
            <button
              type="button"
              @click="showPassword = !showPassword"
              style="
                position: absolute;
                right: 14px;
                top: 50%;
                transform: translateY(-50%);
                background: none;
                border: none;
                cursor: pointer;
                color: #a0b0a8;
                padding: 0;
                display: flex;
                align-items: center;
                transition: color 0.2s;
              "
              @mouseenter="e => e.currentTarget.style.color='#3d8b66'"
              @mouseleave="e => e.currentTarget.style.color='#a0b0a8'"
            >
              <!-- Eye open -->
              <svg v-if="!showPassword" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                <circle cx="12" cy="12" r="3"/>
              </svg>
              <!-- Eye closed -->
              <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                <line x1="1" y1="1" x2="23" y2="23"/>
              </svg>
            </button>
          </div>
        </div>

        <!-- Remember Me -->
        <div
          style="
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
          "
        >
          <div
            @click="remember = !remember"
            style="
              width: 18px;
              height: 18px;
              border-radius: 5px;
              border: 2px solid;
              cursor: pointer;
              display: flex;
              align-items: center;
              justify-content: center;
              flex-shrink: 0;
              transition: all 0.15s;
            "
            :style="{
              backgroundColor: remember ? '#3d8b66' : 'transparent',
              borderColor: remember ? '#3d8b66' : '#c5d4cc',
            }"
          >
            <svg v-if="remember" width="11" height="9" viewBox="0 0 11 9" fill="none">
              <path d="M1 4L4.5 7.5L10 1.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </div>
          <span
            style="
              font-size: 13.5px;
              color: #5a6b62;
              font-family: 'Segoe UI', system-ui, sans-serif;
              cursor: pointer;
              user-select: none;
            "
            @click="remember = !remember"
          >Ingat saya</span>
        </div>

        <!-- Submit Button -->
        <button
          type="submit"
          :disabled="loading"
          style="
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #3d8b66 0%, #2e6e50 100%);
            color: #fff;
            font-size: 15px;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            font-family: 'Segoe UI', system-ui, sans-serif;
            letter-spacing: 0.2px;
            box-shadow: 0 4px 16px rgba(46,110,80,0.35);
            transition: opacity 0.2s, transform 0.1s, box-shadow 0.2s;
          "
          @mouseenter="e => { if (!loading) { e.target.style.background='linear-gradient(135deg, #357a5a 0%, #265e44 100%)'; e.target.style.boxShadow='0 6px 20px rgba(46,110,80,0.45)' } }"
          @mouseleave="e => { e.target.style.background='linear-gradient(135deg, #3d8b66 0%, #2e6e50 100%)'; e.target.style.boxShadow='0 4px 16px rgba(46,110,80,0.35)' }"
          @mousedown="e => { if (!loading) e.target.style.transform='scale(0.98)' }"
          @mouseup="e => e.target.style.transform='scale(1)'"
        >
          <span v-if="!loading">Login</span>
          <span v-else style="display: flex; align-items: center; justify-content: center; gap: 8px;">
            <svg style="animation: spin 0.8s linear infinite;" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/>
            </svg>
            Loading...
          </span>
        </button>
      </form>

      <!-- Footer -->
      <div
        style="
          text-align: center;
          font-size: 11.5px;
          color: #aab8b2;
          margin-top: 28px;
          font-family: 'Segoe UI', system-ui, sans-serif;
        "
      >
        © 2026 HRD Saya
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '@/services/api'

const router = useRouter()

const email = ref('')
const password = ref('')
const remember = ref(false)
const showPassword = ref(false)
const loading = ref(false)
const errorMessage = ref(null)

const handleLogin = async () => {
  loading.value = true
  errorMessage.value = null

  try {
    const response = await api.post('/login', {
      email: email.value,
      password: password.value
    })

    localStorage.setItem('token', response.data.token)

    if (remember.value) {
      localStorage.setItem('remember_email', email.value)
    } else {
      localStorage.removeItem('remember_email')
    }

    router.push('/dashboard')

  } catch (error) {
    errorMessage.value =
      error.response?.data?.message || 'Email atau password salah'
  } finally {
    loading.value = false
  }
}
</script>

<style>
@keyframes spin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}
</style>