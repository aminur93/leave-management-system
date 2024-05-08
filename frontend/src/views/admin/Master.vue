<script>
import LeaveLayout from "@/components/admin/Layout.vue";

export default {
  name: "LeaveMaster",
  components: {LeaveLayout}
}
</script>

<template>
  <v-app>

    <LeaveLayout />

    <v-main>
      <router-view></router-view>
    </v-main>

  </v-app>
</template>

<style scoped>

</style>