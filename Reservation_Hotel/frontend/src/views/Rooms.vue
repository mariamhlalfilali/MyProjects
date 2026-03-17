<script setup>
import { ref, onMounted } from "vue"
import axios from "../axios"
import { useRoute, useRouter } from "vue-router"

const rooms = ref([])
const route = useRoute()
const router = useRouter()
const userName = localStorage.getItem("user_name") || "User"

onMounted(async () => {
  const res = await axios.get(`/hotels/${route.params.id}/rooms`)
  rooms.value = res.data
})

const goReserve = (room) => {
  // Navigate to Reserve page with room info
  router.push({ name: "Reserve", params: { roomId: room.id } })
}

const logout = () => {
  localStorage.removeItem("token")
  localStorage.removeItem("user_name")
  router.push("/")
}
</script>

<template>
  <div>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg shadow-sm" style="background-color: orange;">
      <div class="container">
        <a class="navbar-brand text-white fw-bold" href="#">
          <i class="bi bi-house-fill"></i> HotelApp
        </a>
        <div class="ms-auto">
          <span class="text-white me-3">Welcome, {{ userName }}</span>
          <button @click="logout" class="btn btn-light btn-sm">Logout</button>
        </div>
      </div>
    </nav>

    <div class="container mt-4">
      <h2 class="text-center mb-4" style="color: orange;">Rooms</h2>

      <div class="row">
        <div class="col-md-4 mb-4" v-for="r in rooms" :key="r.id">
          <div class="card shadow h-100" style="border-radius: 15px;">
            <img v-if="r.image" :src="'http://127.0.0.1:8000/storage/' + r.image" 
                 class="card-img-top" style="height: 200px; object-fit: cover;" />
            <div class="card-body">
              <h5 class="card-title">{{ r.name }}</h5>
              <p class="text-muted">{{ r.description || "No description" }}</p>
              <p><strong>Price:</strong> {{ r.price }} DH / night</p>
              <p><strong>Capacity:</strong> {{ r.capacity }} person(s)</p>

              <button @click="goReserve(r)" class="btn w-100 text-white" style="background-color: orange;">
                Reserve
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card:hover {
  transform: scale(1.03);
  transition: 0.3s;
}
</style>