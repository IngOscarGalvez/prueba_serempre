<template>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>

        </ul>

        <!-- SEARCH FORM -->

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">


            <li class="nav-item">



            </li>


        </ul>

        <div>
            <b-button v-b-toggle.sidebar-right><i class="far fa-user"></i> Cuenta</b-button>
            <b-sidebar id="sidebar-right" title="Account" right shadow>



                <div class="mx-auto mt-4 " style="width: 8rem;">

                    <b-avatar variant="primary" size="8rem" v-if="rol==='Admin'">

                    </b-avatar>

                    <b-avatar variant="warning" size="8rem" v-if="rol==='Asesor'">

                    </b-avatar>



                </div>

                <div class="user mx-auto mt-4">
                    <h4 >
                        {{name}}
                    </h4>
                    <h6 >
                        {{email}}
                    </h6>
                    <h6 >
                        Rol: {{rol}}
                    </h6>

                </div>

                <div class="px-3 py-2">

                    <button class="btn btn-outline-primary btn-block" v-b-modal.modalAcount><span class="fas fa-cogs"></span> Perfil</button>

                    <b-modal ref="modalAcount" id="modalAcount"
                             size="lg"

                             :header-bg-variant="headerBgVariant"
                             :header-text-variant="headerTextVariant"
                             @ok="enviar()"
                    >
                        <template v-slot:modal-title>
                            <span class="fas fa-cogs"></span>  {{title}}
                        </template>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre:</label>
                            <input type="text" class="form-control" id="name" v-model="nameAcount" >
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo Electronico:</label>
                            <input type="email" class="form-control" id="email" v-model="emailAcount" >
                        </div>

                        <div class="form-group">
                            <label for="pass" class="col-form-label">Nueva Contraseña:</label>
                            <div class="input-group mb-3">
                                <input :type="passwordFieldType" class="form-control" id="pass" v-model="passwordAcount">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="button" id="button-addon2" @click="switchVisibility()">Show/Hide</button>
                                </div>
                            </div>

                        </div>



                    </b-modal>

                </div>
                <div class="px-3 py-2">

                    <form id="logout-form" action="/logout" method="POST">

                        <input type="hidden" name="_token" :value="csrfToken">

                        <button type="submit" class="btn btn-outline-danger btn-block"><span class="fas fa-sign-out-alt"></span> Cerrar Sesión</button>
                    </form>
                </div>
            </b-sidebar>
        </div>





    </nav>
    <!-- /.navbar -->



</template>

<script>
    export default {



        data(){
            return{
                //variables globales
                csrfToken:'',
                acount:[],
                headerBgVariant:'primary',
                headerTextVariant:'light',
                title:'Editar Perfil',
                nameAcount:'',
                emailAcount:'',
                name:'',
                email:'',
                rol:'',
                passwordAcount:'',
                passwordFieldType: 'password'



            }
        },
        methods : {

            listarUsuario(){

                let me=this;
                var url= '/acount';
                axios.get(url)
                    .then(function (response) {
                        // handle success

                        me.acount=response.data;

                        me.nameAcount=response.data.user.name;
                        me.emailAcount=response.data.user.email;

                        me.name=response.data.user.name;
                        me.email=response.data.user.email;
                        me.rol=response.data.rol;

                        //

                    })
                    .catch(function (error) {

                        console.log(error);
                    })

            },

            switchVisibility() {
                this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
            },

            enviar(){
                let me=this;
                axios.post('/UpdateUser',{
                    'name':this.nameAcount,
                    'email':this.emailAcount,
                    'password':this.passwordAcount,
                    '_token':this.csrfToken

                })
                    .then(function (response) {
                        // handle success
                        me.listarUsuario();
                    })
                    .catch(function (error) {

                        console.log(error);
                    })
            }






        },
        mounted() {
            this.listarUsuario();
            this.csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        }
    }



</script>

<style>
    .user{
        width: auto;
        color:#fff;
        text-align: center;
    }
    .b-sidebar > .b-sidebar-body {
        background-color: #000 !important;
    }

</style>
