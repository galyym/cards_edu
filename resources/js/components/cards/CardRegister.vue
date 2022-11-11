<template>
    <div class="contaiber">
        <form id="card" @submit.prevent="submitForm"></form>
        <div class="form-group">
            <label for="" class="mt-3">RFID номер: {{rfid}}</label>
            <br>
            <label for="" class="mt-3">Номер карты: {{card_number}}</label>
            <br>
            <label for="" class="mt-3">NFC: {{nfc}}</label>
            <br>
            <input type="text" id="temp" @blur="focusMe()">
        </div>
    </div>
</template>

<script>
const arr = ["card_number", "nfc"]

export default {
    name: "CardRegister",
    data: ()=> ({
        interval: null,
        temp: null,
        element_id: null,
        rfid: null,
        card_number: null,
        nfc: null,
        tempEl: null,
    }),

    mounted() {
        this.tempEl = document.getElementById("temp");
        this.tempEl.focus();
        this.getRfid();
    },

    methods: {
        getRfid() {
            if (this.interval) return
            this.interval = setInterval(() =>{
                axios.get("http://192.168.31.121:8400/tablerfid:5102:com3")
                    // axios.get("http://127.0.0.1:8400/tablerfid:5102:/dev/ttyUSB0")
                    .then(response => {
                        console.log(response.data)
                        this.rfid = response.data;
                        this.stopInterval()
                        this.cycle()
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            }, 2000)
        },

        stopInterval(){
            clearInterval(this.interval)
        },

        cycle() {
            this.tempEl.addEventListener("keyup", this.myListener);
        },

        myListener(event) {
            if (event.keyCode === 13) {
                this.element_id = arr.shift()
                this.temp = this.tempEl.value;
                if (this.element_id === "card_number") {
                    this.card_number = this.temp
                }
                if (this.element_id === "nfc") {
                    this.nfc = this.temp
                }

                this.tempEl.value = ""
                this.temp = '';
                if(arr.length === 0){
                    this.submitForm()
                }
            }
            event.preventDefault();
        },

        focusMe() {
            this.tempEl.focus();
        },
        submitForm(){
            const formData = new FormData();
            formData.append('rfid', this.rfid);
            formData.append('card_number', this.card_number);
            formData.append('nfc', this.nfc);

            axios.post('/api/card', formData)
                .then(response => {
                // this.success = 'Data saved successfully';
                // this.response = JSON.stringify(response, null, 2)
                    if (response.data === "success"){
                        alert("Карта успешно добавлена")
                    }else{
                        alert('Ошибка!')
                    }
                    location.reload();
                })
            // .catch(error => {
            //     this.response = 'Error: ' + error.response.status
            // })
            // this.name = '';
            // this.email = '';
            // this.firstSon = '';
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
