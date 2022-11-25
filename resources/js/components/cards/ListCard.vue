<template>
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">№</th>
                <th scope="col">Номер карты</th>
                <th scope="col">RFID</th>
                <th scope="col">NFC</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in listCard">
                <th scope="row">1</th>
                <td>{{ item.card_number }}</td>
                <td>{{ item.rfid }}</td>
                <td>{{ item.nfc }}</td>
            </tr>
            </tbody>
        </table>

        <form class="w-50 align-content-center" @submit.prevent="getForm" method="post">
            <label>Введите начальный номер карты (например: 1000)</label>
            <input class="form-control mt-1 mb-2" type="number" name="start" v-model="start">
            <label class="mt-3">Введите последний номер карты (например: 1050)</label>
            <input class="form-control mt-1 mb-3" type="number" name="end" v-model="end">
            <button class="btn btn-success">Скачать список карт</button>
        </form>
    </div>
</template>

<script>
export default {
    name: "ListCard",

    data: ()=> ({
        listCard: null,
        start: null,
        end: null
    }),

    mounted() {
        this.getCard()
    },

    methods: {
        getCard(){
            axios.get('/api/list')
                .then(res => {
                    this.listCard = res.data
                })
        },

        getForm(){
            const formData = new FormData();
            formData.append('start', this.start);
            formData.append('end', this.end);

            axios.post('api/gen/pdf', formData)
                .then((response) => {
                    alert("PDF генерирован начиная с " + response.data.start + " до " + response.data.end);
                })
                .catch((error) => {
                    console.log(error)
                })
        }
    }
}
</script>

<style scoped>

</style>
