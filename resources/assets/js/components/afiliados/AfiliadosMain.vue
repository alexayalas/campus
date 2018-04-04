<template>
    <!-- PAGE CONTENT WRAPPER -->
    <div class="page-content-wrap">
        <div class="row">
            <afimenu></afimenu>
            <router-view></router-view>
        </div>
    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</template>
<script>
import { mapGetters } from 'vuex'
import AfiMenu from './content/AfiMenu.vue'

export default {
    name:'afiliadosmain',
    components:
                {'afimenu': AfiMenu},
    data() {
        return {

        }
    },
    created() {
        this.$store.dispatch('LOAD_DATA_INIT_LIST')        
    }    
  
}
</script>