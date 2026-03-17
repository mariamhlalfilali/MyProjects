<script setup>
import { ref } from "vue"
import axios from "../axios"
import { useRouter } from "vue-router"

const email = ref("")
const password = ref("")
const router = useRouter()

const login = async () => {
  try {
    const res = await axios.post("/login", {
      email: email.value,
      password: password.value
    })
    localStorage.setItem("token", res.data.access_token)
    router.push("/hotels")
  } catch (err) {
    alert("Invalid credentials")
  }
}
</script>

<template>
  <div class="container py-5" style="max-width: 400px;">
    <h2 class="text-center mb-4" style="color: orange;">Hotel Booking</h2>

    <form @submit.prevent="login" class="border p-4 rounded shadow-sm" style="background-color: #fff;">
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input v-model="email" type="email" class="form-control" placeholder="Enter email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input v-model="password" type="password" class="form-control" placeholder="Enter password" required>
      </div>

      <button type="submit" class="btn w-100 text-white" style="background-color: orange;">
        Login
      </button>
    </form>

    <p class="text-center mt-3">
      Don't have an account?
      <router-link to="/register" style="color: orange; font-weight: bold;">Sign Up</router-link>
    </p>
  </div>
</template>