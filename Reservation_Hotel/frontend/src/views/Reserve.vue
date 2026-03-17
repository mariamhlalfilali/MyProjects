<script setup>
import { ref, onMounted } from "vue"
import axios from "../axios"
import { useRoute, useRouter } from "vue-router"
import Alert from "./Alert.vue" 

const route = useRoute()
const router = useRouter()

const room = ref({})
const checkIn = ref("")
const checkOut = ref("")

const successMessage = ref("")
const errorMessage = ref("")

onMounted(async () => {
  const res = await axios.get(`/rooms/${route.params.roomId}`)
  room.value = res.data
})

const reserveRoom = async () => {
  if (!checkIn.value || !checkOut.value) {
    errorMessage.value = "Please select check-in and check-out dates"
    setTimeout(() => (errorMessage.value = ""), 3000)
    return
  }

  try {
    await axios.post("/reservations", {
      room_id: room.value.id,
      check_in: checkIn.value,
      check_out: checkOut.value
    })
    successMessage.value = "Reservation done successfully! 🎉"
    setTimeout(() => {
      successMessage.value = ""
      router.push("/hotels")
    }, 3000)
  } catch (err) {
    errorMessage.value = err.response?.data?.message || "Error making reservation"
    setTimeout(() => (errorMessage.value = ""), 3000)
  }
}
</script>

<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4" style="color: orange;">Reserve {{ room.name }}</h2>

    <!-- ✅ Alert messages -->
    <Alert :message="successMessage" type="success" />
    <Alert :message="errorMessage" type="error" />

    <div class="card shadow p-4" style="max-width: 500px; margin: auto; border-radius: 15px;">
      <img v-if="room.image" :src="'http://127.0.0.1:8000/storage/' + room.image"
           class="card-img-top mb-3" style="height: 250px; object-fit: cover; border-radius: 10px;"/>

      <p><strong>Description:</strong> {{ room.description || "No description" }}</p>
      <p><strong>Price:</strong> {{ room.price }} DH / night</p>
      <p><strong>Capacity:</strong> {{ room.capacity }} person(s)</p>

      <div class="mb-3">
        <label class="form-label">Check-in</label>
        <input type="date" v-model="checkIn" class="form-control"/>
      </div>

      <div class="mb-3">
        <label class="form-label">Check-out</label>
        <input type="date" v-model="checkOut" class="form-control"/>
      </div>

      <button @click="reserveRoom" class="btn w-100 text-white" style="background-color: orange;">
        Confirm Reservation
      </button>
    </div>
  </div>
</template>