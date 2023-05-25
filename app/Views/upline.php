<div class="wrapper">

  
<?= view('navbar/' . session()->get('access') ); ?>
<?= view('sidebar/' . session()->get('access')); ?>

<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Update Uplines for <?= $currentItem['name']; ?>
              </h1>

            </div>
            

          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content"  id="app">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">

               
                
                
                    

                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Current Operator: {{current_operator}} </h3>

                    </div>

                    <div class="card-body">
                        

                        <v-text-field
                            :loading="loading"
                            v-model="search_operator"
                            @keyup="load_operators"
                            density="compact"
                            variant="solo"
                            label="Search New Operator"
                            append-inner-icon="mdi-magnify"
                            single-line
                            hide-details
                        ></v-text-field>

                        <v-radio-group  v-model="selected_operator">
                            <v-radio :key="x.id"  v-for="x in operators" :label="x.name" :value="x.id" ></v-radio>
                        </v-radio-group>

                        <v-btn @click="update_operator" variant="outlined" :disabled=" selected_operator=='' " class="bg-blue text-white">
                            Update New Operator
                        </v-btn>
                        
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Current Area Distributor: {{current_super_agent}} </h3>

                    </div>

                    <div class="card-body">
                        

                        <v-text-field
                            :loading="loading"
                            v-model="search_super_agent"
                            @keyup="load_super_agent"
                            density="compact"
                            variant="solo"
                            label="Search New Area Distributor"
                            append-inner-icon="mdi-magnify"
                            single-line
                            hide-details
                        ></v-text-field>

                        <v-radio-group  v-model="selected_super_agent">
                            <v-radio :key="x.id"  v-for="x in super_agents" :label="x.name" :value="x.id" ></v-radio>
                        </v-radio-group>

                        <v-btn @click="update_super_agent" variant="outlined" :disabled=" selected_super_agent=='' " class="bg-blue text-white">
                            Update New Area Distributor
                        </v-btn>
                        
                    </div>
                </div>


              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    
    <?= view('footer/copyright'); ?>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
      <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
  </div>
<!-- ./wrapper -->

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  const base_url = '<?= base_url(); ?>/api/';
  const current_id = '<?= $currentItem['id']; ?>';

  
    var v = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        methods: {
            load_operators (){
                v.loading = true;
                api('search_operator', {operator: v.search_operator},(data)=>{
                    v.operators = data;
                    v.loading = false;
                } );
            },
            load_super_agent (){
                v.loading = true;
                api('search_super_agent', {super_agent: v.search_super_agent},(data)=>{
                    v.super_agents = data;
                    v.loading = false;
                } );
            },
            update_operator (){
                Swal.fire({
                    title: 'Do you want to change HALL OPERATOR?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Update Now',
                    denyButtonText: `No`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        api('update_operator', {id: current_id, operator_id:v.selected_operator},(data)=>{
                            Swal.fire('Saved!', '', 'success').then(()=>{history.back();});
                        } );
                        
                    } else if (result.isDenied) {
                        Swal.fire('Update Cancled', '', 'info')
                    }
                })
            },
            update_super_agent (){
                Swal.fire({
                    title: 'Do you want to change Area Distributor?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Update Now',
                    denyButtonText: `No`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        api('update_super_agent', {id: current_id, super_agent_id: v.selected_super_agent},(data)=>{
                            Swal.fire('Saved!', '', 'success').then(()=>{history.back();});
                        } );
                        
                    } else if (result.isDenied) {
                        Swal.fire('Update Cancled', '', 'info')
                    }
                })
            },
        },
        data () {
                    return {
                        loading: false,
                        search_operator: '',
                        selected_operator: '',
                        operators: [],
                        current_operator: '<?= $operator['name']; ?>',
                        search_super_agent: '',
                        selected_super_agent: '',
                        super_agents: [],
                        current_super_agent: '<?= $super_agent['name']; ?>',
                    }
                },
        created: ()=>{
            api('search_operator', {operator: ''},(data)=>{
                    v.operators = data;
                } );
        }
    });

    function api(key,params,callback){
        axios({
                method: 'post',
                url: base_url + key,
                data: params
            })
            .then(res => {
                if(callback!== undefined) callback(res.data.data);
            })
    }

        
</script>

<?= view('scripts/dashboard'); ?>