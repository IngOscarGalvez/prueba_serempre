<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Administrador de Clientes</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="/">Principal</a>
                            </li>
                            <li class="breadcrumb-item active">
                                Administrador de Clientes
                            </li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <b-button
                                v-b-modal.modal
                                @click="modal()"
                                size="sm"
                                variant="primary"
                                ><i class="fas fa-plus"></i> Crear
                                Cliente</b-button
                            >

                            <div>
                                <b-modal
                                    ref="modal"
                                    id="modal"
                                    size="lg"
                                    :header-bg-variant="headerBgVariant"
                                    :header-text-variant="headerTextVariant"
                                    hide-footer
                                >
                                    <template v-slot:modal-title>
                                        <span class="fas fa-cogs"></span>
                                        {{ modal_text }}
                                    </template>

                                    <form
                                        @submit.prevent="handlerSubmit()"
                                        ref="handlerSubmit"
                                    >
                                        <b-form-group
                                            id="fieldset-1"
                                            label="Nombre"
                                            label-for="name"
                                            valid-feedback="El nombre ingresado es valido Gracias!"
                                            :invalid-feedback="
                                                invalidFeedbackName
                                            "
                                            :state="stateName"
                                            class="font-weight-bold"
                                        >
                                            <!-- State: pone el input correcto -->
                                            <b-form-input
                                                id="name"
                                                v-model.trim="formData.name"
                                                :state="stateName"
                                                trim
                                                placeholder="Nombre"
                                                maxlength="60"
                                                class="my-2 p-2"
                                                type="text"
                                                autocomplete="off"
                                            ></b-form-input>
                                        </b-form-group>

                                        <b-form-group
                                            id="fieldset-1"
                                            label="Ciudad"
                                            label-for="city"
                                            valid-feedback="La ciudad Ingresada es valida Gracias!"
                                            :invalid-feedback="
                                                invalidFeedbackCity
                                            "
                                            :state="stateCity"
                                            class="font-weight-bold"
                                        >
                                            <!-- State: pone el input correcto -->
                                            <b-form-select
                                                id="city"
                                                v-model.trim="formData.city"
                                                :state="stateCity"
                                                trim
                                                class="my-2 p-2"
                                                :options="optionsSelect"
                                            >
                                            </b-form-select>
                                        </b-form-group>

                                        <b-button
                                            class="mt-3"
                                            @click="$bvModal.hide('modal')"
                                            >Cerrar</b-button
                                        >

                                        <button
                                            class="btn btn-primary mt-3"
                                            type="submit"
                                        >
                                            Guardar
                                        </button>
                                    </form>
                                </b-modal>
                            </div>
                        </div>
                        <div class="card-body">
                            <v-server-table
                                ref="table"
                                :url="'/clients'"
                                :columns="columns"
                                :data="array"
                                :options="options"
                            >
                                <div slot="options" slot-scope="props">
                                    <b-button-group size="sm">
                                        <b-button
                                            @click="select(props.row)"
                                            v-b-tooltip.hover.bottom="
                                                'Modificar Cliente'
                                            "
                                            size="sm"
                                            variant="primary"
                                            ><i class="fas fa-pen-alt"></i
                                        ></b-button>
                                        <b-button
                                            @click="
                                                eliminar(props.row.client_id)
                                            "
                                            v-b-tooltip.hover.bottom="
                                                'Borrar Cliente'
                                            "
                                            size="sm"
                                            variant="danger"
                                            ><i class="fas fa-trash"></i
                                        ></b-button>
                                    </b-button-group>
                                </div>

                                <div slot="created_at" slot-scope="props">
                                    {{
                                        new Date(
                                            props.row.created_at
                                        ).toLocaleString()
                                    }}
                                </div>
                            </v-server-table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
export default {
    data() {
        return {
            //variables globales
            csrfToken: "",
            modal_text: "",
            array: [],
            tipo: 0,
            role_s: "",
            optionsSelect: [],
            headerBgVariant: "primary",
            headerTextVariant: "light",
            columns: ["client_name", "city_name", "options"],
            options: {
                skin: "table-striped table-bordered table-hover table-sm",
                columnsDropdown: true,
                perPage: 10,
                perPageValues: [5, 10, 15, 20],
                headings: {
                    client_name: "Nombre",
                    city_name: "Ciudad",
                    options: "Opciones"
                },
                sortable: ["client_name", "city_name"],
                filterable: ["client_name"]
            },

            formData: {
                client_id: "",
                name: "",
                city: 0,
                validated: {
                    name: false,
                    city: false
                },

                alertError: false
            },

            modeCreate: false
        };
    },
    methods: {
        listar() {
            this.$refs.table.refresh();
        },

        handlerSubmit() {
            const {
                name,
                validated: { name: nameValidation }
            } = this.formData;

            if (!nameValidation) {
                // add variable to true and throw an error
                return;
            }

            // add variable to false
            if (this.modeCreate) {
                this.create();
            } else {
                this.update();
            }
            // send to the back-end
        },

        eliminar(row) {
            let me = this;
            this.$bvModal
                .msgBoxConfirm("Deseas Eliminar el Cliente?")
                .then(value => {
                    if (value) {
                        axios
                            .delete("/cities/" + row, {
                                id: row,
                                _token: this.csrfToken
                            })
                            .then(function(response) {
                                // handle success
                                me.listar();
                                me.$bvToast.toast("Usuario Eliminado!!", {
                                    title: `Info`,
                                    variant: "success",
                                    solid: true
                                });
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                })
                .catch(err => {
                    // An error occurred
                });
        },

        modal() {
            this.modeCreate = true;
            this.modal_text = "Crear Cliente";
            this.formData.name = "";
            this.formData.city = 0;
        },
        switchVisibility() {
            this.passwordFieldType =
                this.passwordFieldType === "password" ? "text" : "password";
        },
        select(data) {
            this.modeCreate = false;

            this.modal_text = "Actualizar Cliente";
            this.formData.name = data.client_name;
            this.formData.city = data.client_id;
            this.formData.client_id = data.client_id;
            this.$refs["modal"].show();
        },
        update() {
            let me = this;
            axios
                .put("/clients/" + this.formData.client_id, {
                    name: this.formData.name,
                    city_id: this.formData.city,
                    _token: this.csrfToken
                })
                .then(function(response) {
                    // handle success
                    me.listar();
                    me.$refs["modal"].hide();
                    me.$bvToast.toast("Cliente Actualizado!!", {
                        title: `Info`,
                        variant: "success",
                        solid: true
                    });
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        create() {
            let me = this;
            axios
                .post("/clients", {
                    name: this.formData.name,
                    city_id: this.formData.city,
                    _token: this.csrfToken
                })
                .then(function(response) {
                    // handle success
                    me.listar();
                    me.$refs["modal"].hide();

                    me.$bvToast.toast("Cliente Creado!!", {
                        title: `Info`,
                        variant: "success",
                        solid: true
                    });
                })
                .catch(function(error) {
                    console.log(error);
                });
        },
        listOption() {
            let me = this;
            axios
                .get("/listCities")
                .then(function(response) {
                    // handle success
                    me.optionsSelect = response.data;
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    },

    computed: {
        stateName() {
            return this.formData.name.length > 3
                ? true
                : this.formData.name.length == 0
                ? null
                : false;
        },
        invalidFeedbackName() {
            if (this.formData.name.length < 3) {
                this.formData.validated.name = false;
                return "Por favor ingresa un nombre valido.";
            }
            this.formData.validated.name = true;
        },
        stateCity() {
            return this.formData.city > 0
                ? true
                : this.formData.city == ""
                ? null
                : false;
        },
        invalidFeedbackCity() {
            if (this.formData.city > 0) {
                this.formData.validated.city = false;
                return "Por favor Seleccione una Ciudad.";
            }

            this.formData.validated.city = true;
        }
    },

    mounted() {
        this.listar();
        this.listOption();
        this.csrfToken = document.querySelector(
            'meta[name="csrf-token"]'
        ).content;
    }
};
</script>
