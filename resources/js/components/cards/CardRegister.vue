<template>
    <div class="contaiber">
        <form id="card" @submit.prevent="submitForm"></form>
        <div class="form-group">
            <label>Номер карты: </label> <input id="card_number" type="number" class="mt-3">
            <br>
            <label>ФИО студента: </label><input id="student_name" type="text" class="mt-3">
            <br>
            <label>RFID: </label><input id="rfid" type="text" class="mt-3">
            <br>
            <label>NFC: </label><input id="nfc" type="text" class="mt-3">
            <br>
            <input type="text" id="temp" @blur="focusMe()">
            <div id="msg"></div>
        </div>
    </div>
</template>

<script>
const arr = ["card_number", "rfid"]
export default {
    name: "CardRegister",
    data: ()=> ({
        interval: null,
        temp: null,
        card_number: null,
        nfc: null,
        tempEl: null,
        student_name: null,
        rfid: null,
        element_id: null
    }),

    mounted() {
        this.tempEl = document.getElementById("temp");
        this.tempEl.focus();
        this.cycle();
    },

    methods: {
        cycle() {
            this.tempEl.addEventListener("keyup", this.myListener);
        },

        myListener(event) {
            if (event.keyCode === 13) {

                this.element_id = arr.shift()
                this.temp = this.tempEl.value;

                // if (this.element_id === "card_number") {
                    this.card_number = this.temp
                    document.getElementById('card_number').value = this.card_number
                    this.getStudentName();
                // }
                // if (this.element_id === "rfid") {
                    this.getRfid();
                // }
                // this.tempEl.value = ""
                // this.temp = '';
                //
                // if (arr.length === 0){


                // }
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
            formData.append('rfid', this.rfid);
            if (this.card_number !== this.nfc){
                axios.post('/api/card', formData)
                    .then(response => {
                        if (response.data === "success"){
                            document.getElementById("msg").innerText = "Карта успешно добавлена\n" + "Номер карты: " + this.card_number + "\nNFC: " + this.nfc;
                            setTimeout(() => {
                                document.getElementById("msg").innerText = "";
                            }, 1000);
                        }
                        location.reload();
                    }).catch( error => {
                    if (error.response.status === 400){
                        alert("Карта не добавлена, перепроверьте данные.")
                        location.reload();
                    }
                })
            }else {
                alert("Вы перепутали что-то");
                location.reload();
            }
        },

        getStudentName(){
            // console.log(formData);
            axios.get("api/student/name", {
                params: {
                    "card_number": this.card_number
                }
            })
                .then(data => {
                    this.student_name = data.data.name;
                    document.getElementById('student_name').value = this.student_name
                })
                .catch(error => {
                    if (error.response.status === 404){
                        alert('Номер карты не найдена');
                        location.reload();
                    }else if (error.response.status === 400){
                        alert('К этой карте никто не зарегистрировано');
                        location.reload();
                    }
                })
        },

        getRfid() {
            if (this.interval) return
            this.interval = setInterval(() =>{
                // axios.get("http://192.168.31.159:8400/tablerfid:5102:com3")
                axios.get("http://127.0.0.1:8400/tablerfid:5102:com3")
                    .then(response => {
                        console.log(response.data)
                        this.rfid = response.data;
                        document.getElementById('rfid').value = this.rfid
                        this.stopInterval();

                        readNFC(60000, 400, data => {
                            this.nfc = data.slice(9, 19);
                            document.getElementById('nfc').value = this.nfc;

                            this.submitForm();
                        });
                    })
                    .catch(error => {
                        console.log(error.response)
                    })
            }, 2000)
        },

        stopInterval(){
            clearInterval(this.interval);
        },

    },
    destroyed() {
        this.stopInterval();
        this.tempEl.removeEventListener("keyup", this.myListener);

    },

}
</script>

<style scoped>

</style>
