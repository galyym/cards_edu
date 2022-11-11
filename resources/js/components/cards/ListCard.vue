<template>
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
</template>

<script>
export default {
    name: "ListCard",

    data: ()=> ({
        listCard: null,
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
        }
    }

}
</script>

<style scoped>

</style>
