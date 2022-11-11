<template>
    <main>
        <div class="row w-100">
            <div class="col-2">
                <div class="nav flex-column nav-pills bg-light" style="height: 100vh;" id="v-pills-tab myDIV" role="tablist" aria-orientation="vertical">
                    <router-link to="/" class="nav-link actBtn active" style="margin-top: 15%">Карты</router-link>
                    <router-link to="/register" class="nav-link actBtn">Регистрировать</router-link>
                    <router-link to="/generate" class="nav-link actBtn">Генерировать</router-link>
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
    // let header = document.getElementById("myDIV");
    // let btns = document.getElementsByClassName("actBtn");
    // for (let i = 0; i < btns.length; i++) {
    //     btns[i].addEventListener("click", function() {
    //         var current = document.getElementsByClassName("active");
    //         current[0].className = current[0].className.replace(" active", "");
    //         this.className += " active";
    //     });
    // }
</script>

<style>
    /*.active, .activ:hover {*/
    /*    background-color: #666;*/
    /*    color: white;*/
    /*}*/
</style>
