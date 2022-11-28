<template>
    <div class="contaiber">
        <form id="card" @submit.prevent="submitForm"></form>
        <div class="form-group">
            <label for="" class="mt-3">Номер карты: {{card_number}}</label>
            <br>
            <label for="" class="mt-3">NFC: {{nfc}}</label>
            <br>
            <input type="text" id="temp" @blur="focusMe()">
        </div>
    </div>
</template>

<script>
const arr = ["card_number"]

export default {
    name: "CardRegister",
    data: ()=> ({
        interval: null,
        temp: null,
        element_id: null,
        card_number: null,
        nfc: null,
        tempEl: null,
    }),

    mounted() {
        this.tempEl = document.getElementById("temp");
        this.tempEl.focus();
        this.cycle();
    },

    methods: {
        cycle() {
            readNFC(40000, 400, data => {
                this.nfc = data.slice(9, 19);
            });
            this.tempEl.addEventListener("keyup", this.myListener);
        },

        myListener(event) {
            if (event.keyCode === 13) {
                this.element_id = arr.shift();
                this.temp = this.tempEl.value;
                if (this.element_id === "card_number") {
                    this.card_number = this.temp;
                }
                this.tempEl.value = ""
                this.temp = '';
                if(arr.length === 0){
                    this.submitForm();
                }
            }
            event.preventDefault();
        },

        // фокус на temp
        focusMe() {
            this.tempEl.focus();
        },

        submitForm(){
            const formData = new FormData();
            formData.append('card_number', this.card_number);
            formData.append('nfc', this.nfc);

            axios.post('/api/card', formData)
                .then(response => {
                    if (response.data === "success"){
                        alert("Карта успешно добавлена")
                    }
                    location.reload();
                }).catch( error => {
                        alert('Карта не добавлена ' + error);
                        location.reload();
                })
        },
    },
    destroyed() {
        this.stopInterval();
        this.tempEl.removeEventListener("keyup", this.myListener);

    }
}
</script>

<style scoped>

</style>
