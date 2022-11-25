<template>
    <div class="nav flex-column nav-pills bg-light" style="height: 100vh;" id="v-pills-tab myDIV" role="tablist" aria-orientation="vertical">
        <router-link to="/" class="nav-link actBtn active ui toggle" @click="toggle" style="margin-top: 15%">Карты</router-link>
        <router-link to="/register" class="nav-link actBtn ui toggle" @click="toggle">Регистрировать</router-link>
        <router-link to="/generate" class="nav-link actBtn ui toggle" @click="toggle">Генерировать</router-link>
    </div>
</template>

<script>
export default {
    name: "Nav"
}
</script>

<style scoped>

</style>
