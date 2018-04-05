<template>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <venmenu></venmenu>
            <router-view></router-view>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</template>
<script>
import { mapGetters } from 'vuex'
import VenMenu from './content/VenMenu.vue'

export default {
    name:'vendedoresmain',
    components:
                {'venmenu': VenMenu},
    data() {
        return {

        }
    },
    created() {
        //this.$store.dispatch('LOAD_DATA_INIT_LIST')        
    }    
  
}
</script>