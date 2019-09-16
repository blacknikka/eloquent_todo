<template>
    <div class="top">
        top
        <br/><br/>
        {{hello}}
        <br/>
        login
        <br/><br/>
        <router-link to="/login">
            <button type="button">ログイン</button>
        </router-link>
    </div>
</template>

<script>
    export default {
        components: {  },
        data () {
            return {
                   hello : "hi there",
            }
        },
    }
</script>

