<template>
    <div class="container">
        <form id="card" @submit.prevent="submitForm">
            <div class="form-group">
                <label for="" class="mt-3">Cколько карточек вы хотите сгенерировать?</label>
                <input class="form-control mt-3" type="number" name="amount" v-model="amount">
                <button class="btn btn-primary mt-2" type="submit">Генерировать</button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    name: "GenerateCard",

    data() {
        return{
            amount: null
        }
    },

    mounted() {
    },

    methods: {
        submitForm(){
            const formData = new FormData();
            formData.append('amount', this.amount);

            axios.post('api/generate', formData)
                .then((response) => {
                    alert(response.data);
                })
                .catch((error) => {
                    console.log(error.response);
                });
        }
    }
}
</script>

<style scoped>

</style>
