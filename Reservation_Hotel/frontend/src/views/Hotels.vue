<script setup>
import { ref, onMounted } from "vue"
import axios from "../axios"
import { useRouter } from "vue-router"

const hotels = ref([])
const router = useRouter()
const userName = localStorage.getItem("user_name") || "User"

onMounted(async () => {
  const res = await axios.get("/hotels")
  hotels.value = res.data
})

const goRooms = (id) => {
  router.push(`/rooms/${id}`)
}

const logout = () => {
  localStorage.removeItem("token")
  localStorage.removeItem("user_name")
  router.push("/")
}
</script>

<template>
  <div>
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: orange;">
      <div class="container">

        <!-- Brand -->
        <a class="navbar-brand text-white fw-bold" href="#">
          <i class="bi bi-house-fill"></i> HotelApp
        </a>

        <!-- Toggle button for mobile -->
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon" style="color: white;"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center">
            <li class="nav-item me-3">
              <span class="nav-link text-white fw-bold">
                Welcome, {{ userName }}
              </span>
            </li>

            <li class="nav-item">
              <button @click="logout" class="btn btn-light btn-sm">
                Logout
              </button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <h2 class="text-center mb-4" style="color: orange;">
        Available Hotels
      </h2>

      <div class="row">
        <div class="col-md-4 mb-4" v-for="h in hotels" :key="h.id">
          <div class="card shadow h-100" style="border-radius: 15px;">
            
            <!-- Image (optional) -->
            <img 
              v-if="h.image"
              :src="'http://127.0.0.1:8000/storage/' + h.image" 
              class="card-img-top"
              style="height: 200px; object-fit: cover;"
            />

            <div class="card-body text-center">
              <h5 class="card-title">{{ h.name }}</h5>
              <p class="text-muted">{{ h.city }}</p>

              <button 
                @click="goRooms(h.id)" 
                class="btn text-white"
                style="background-color: orange;"
              >
                View Rooms
              </button>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>
</template>

<style scoped>
.navbar-toggler {
  border-color: white;
}

.navbar-toggler-icon {
  background-image: url("data:image/svg+xml;charset=utf8,%3Csvg viewBox='0 0 30 30' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke='white' stroke-width='2' stroke-linecap='round' stroke-miterlimit='10' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
}
</style>