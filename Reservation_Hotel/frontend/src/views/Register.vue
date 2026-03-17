<script setup>
import { ref } from "vue"
import axios from "../axios"
import { useRouter } from "vue-router"

const name = ref("")
const email = ref("")
const password = ref("")
const password_confirmation = ref("")
const router = useRouter()

const register = async () => {
  try {
    const res = await axios.post("/register", {
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value
    })

    alert("Account created successfully")
    router.push("/") // Redirect to login page
  } catch (err) {
    console.log(err.response)
    alert("Error: " + (err.response?.data?.message || "Check your inputs"))
  }
}
</script>

<template>
  <div class="container d-flex align-items-center justify-content-center vh-100 ">
    <div class="card shadow p-4" style="width: 400px; border-radius: 15px;">
      
      <!-- Title -->
      <h2 class="text-center mb-4" style="color: orange;">
        Create Account
      </h2>

      <!-- Form -->
      <form @submit.prevent="register">
        <div class="mb-3">
          <input v-model="name" type="text" class="form-control" placeholder="Name" required>
        </div>

        <div class="mb-3">
          <input v-model="email" type="email" class="form-control" placeholder="Email" required>
        </div>

        <div class="mb-3">
          <input v-model="password" type="password" class="form-control" placeholder="Password" required>
        </div>

        <div class="mb-3">
          <input v-model="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required>
        </div>

        <button type="submit" class="btn w-100 text-white" style="background-color: orange;">
          Sign Up
        </button>
      </form>

      <!-- Login link -->
      <p class="text-center mt-3">
        Already have an account?
        <router-link to="/" style="color: orange; font-weight: bold;">
          Login
        </router-link>
      </p>

    </div>
  </div>
</template>