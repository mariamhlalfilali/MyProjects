import { createRouter, createWebHistory } from "vue-router"
import Login from "../views/Login.vue"
import Hotels from "../views/Hotels.vue"
import Rooms from "../views/Rooms.vue"
import Register from "../views/Register.vue"
import Reserve from "../views/Reserve.vue"

const routes = [
  { path: "/", component: Login },
  { path: "/register", component: Register },
  { path: "/hotels", component: Hotels },
  { path: "/rooms/:id", component: Rooms },  
  { path: "/reserve/:roomId", name: "Reserve", component: Reserve },

]

export default createRouter({
  history: createWebHistory(),
  routes
})