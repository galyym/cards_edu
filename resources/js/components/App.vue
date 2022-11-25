<template>
    <main>
        <div class="row w-100">
            <div class="col-2">
                <div class="nav flex-column nav-pills bg-light" style="height: 100vh;" id="v-pills-tab myDIV" role="tablist" aria-orientation="vertical">
                    <router-link to="/" class="nav-link actBtn active ui toggle" @click="toggle" style="margin-top: 15%">Карты</router-link>
                    <router-link to="/register" class="nav-link actBtn ui toggle" @click="toggle">Регистрировать</router-link>
                    <router-link to="/generate" class="nav-link actBtn ui toggle" @click="toggle">Генерировать</router-link>
                </div>
            </div>
            <div class="col-10">
                <div class="container mt-5">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    export default {
        data(){
            return {
                activeBtn: '',
                isActive: true
            }
        },
        mounted() {
        },
        methods: {
            toggle(){
                // if(!this.isActive){
                //     this.isActive = true
                // } else {
                //     this.isActive = false
                // }
                this.isActive = !this.isActive
                console.log("Active")
            }
        }
    }
</script>
