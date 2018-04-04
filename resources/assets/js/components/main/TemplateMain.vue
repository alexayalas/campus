<template>

    <div class="page-container">
        <!-- Parte Izquierda de la Plantilla -->
        <navbar v-show="authenticated"></navbar>
        <!-- fin de la Parte Izquierda de la plantilla -->

        <div class="page-content" v-bind:class="{ notmargin : !authenticated }">
            <topbar v-show="authenticated"></topbar>
            <breadcrumb v-show="authenticated"></breadcrumb>
            <router-view></router-view>
        </div>                    

        <!-- footer content -->
        <footervue v-show="authenticated"></footervue>
        <!-- /footer content -->        
    </div>            

</template>
<script>
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'templatemain',
    data () {
        return {
            message:''        
        }
    },
    mounted(){
        console.log("autentificado: ",this.authenticated)
    },
    computed: {
        ...mapState(['authenticated'])
    }

}
</script>
<style scoped>
    .notmargin {
        margin-left: 0 !important;
    }
</style>


