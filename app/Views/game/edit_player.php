<div class="wrapper">

  
<?= view('navbar/' . session()->get('access') ); ?>
<?= view('sidebar/' . session()->get('access')); ?>


<link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">

  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="app">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                Edit Player Details
              </h1>
            </div>
            
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              
                <?php if($valid_access): ?>

                    <div class="card">
                        <div class="card-header">
                        <h3 class="card-title">Edit Player</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">



                            <?php if($saved): ?> 
                                <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Saved!</h5>
                                Player details successfully updated.
                                </div>
                            <?php endif; ?> 



                            <?= form_open('edit_player/' . $player_id); ?>
                            
                                <div style="color:#f00">
                                    <?= ($validation != null) ? $validation->listErrors() : ''; ?>
                                </div>

                                <div class="form-horizontal">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="name" class="col-sm-2 col-form-label">Name</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="name" id="name" value="<?= set_value('name',$default['name']); ?>" placeholder="name">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" value="<?= set_value('phone',$default['phone']); ?>" name="phone" id="phone" placeholder="phone number">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                                            <div class="col-sm-10">
                                                <input type="email" class="form-control" name="email" id="email" value="<?= set_value('email',$default['email']); ?>" placeholder="Email">
                                            </div>
                                        </div>

                                        
                                        <div class="form-group row">
                                            <label for="player_id" class="col-sm-2 col-form-label">Player ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="player_id" id="player_id" value="<?= set_value('player_id',$default['player_id']); ?>" placeholder="player id" <?= ($default['player_id'] == '')? '':'readonly'; ?> >
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="note" class="col-sm-2 col-form-label">Note/Temporary ID</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" name="note" id="note" value="<?= set_value('note',$default['note']); ?>" placeholder="note" >
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-info">
                                    Save
                                    </button>
                                </div>
                                <!-- /.card-footer -->
                            
                            <?= form_close(); ?>
                        </div>
                        

                    </div>
                    
                    <?php if($access == 'super_admin'): ?>
                    
                        <div class="card">
                            <div class="card-header">
                              Network
                            </div>
        
                            <div class="card-body">
                                <h5 >Current Affiliate: <strong>{{current_agent}}</strong> </h5>
                                <h5 >Current Area Distributor: <strong>{{current_super_agent}}</strong> </h5>
                                <h5 >Current Operator: <strong>{{current_operator}}</strong> </h5>
                                
                                <v-text-field
                                    :loading="loading"
                                    v-model="search_agent"
                                    @keyup="load_agent"
                                    density="compact"
                                    variant="solo"
                                    label="Search New Affiliate"
                                    append-inner-icon="mdi-magnify"
                                    single-line
                                    hide-details
                                ></v-text-field>
        
                                <v-radio-group  v-model="selected_agent">
                                    <v-radio :key="x.id"  v-for="x in agents" :label="x.name" :value="x.id" ></v-radio>
                                </v-radio-group>
        
                                <v-btn @click="update_agent" variant="outlined" :disabled=" selected_agent=='' " class="bg-blue text-white">
                                    Update New Affiliate
                                </v-btn>
                                
                            </div>
                        </div>
                    <?php endif; ?>
                    
                <?php endif; ?>

                <?php if(!$valid_access): ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-ban"></i> Invalid Access!</h5>
                        Sorry, you dont have the access to edit this player.
                    </div>
                <?php endif; ?>

                <!-- /.card-body -->
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



<?= view('scripts/js'); ?>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

  var return_url = '<?= base_url( session()->get('access') . "/players"); ?>';
  function returnPage(){
    location.href = return_url;
  }
  
  <?= ($saved) ? 'setTimeout(() => {returnPage()}, 1500);' : ""; ?>
  
  
  
  
  
  const base_url = '<?= base_url(); ?>/api/';
  const current_id = '<?= $player_id; ?>';
  
  var v = new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        methods: {
            load_agent (){
                v.loading = true;
                api('search_agent', {agent: v.search_agent},(data)=>{
                    v.agents = data;
                    v.loading = false;
                } );
            },
            update_agent (){
                Swal.fire({
                    title: 'Do you want to change Affiliate?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Update Now',
                    denyButtonText: `No`,
                    }).then((result) => {
                    if (result.isConfirmed) {
                        api('update_agent', {id: current_id, agent_id: v.selected_agent},(data)=>{
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
                        search_agent: '',
                        selected_agent: '',
                        agents: [],
                        current_agent: '<?= $agent['name']; ?>',
                        current_super_agent: '<?= $super_agent['name']; ?>',
                        current_operator: '<?= $operator['name']; ?>',
                    }
                },
        created: ()=>{
            //
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