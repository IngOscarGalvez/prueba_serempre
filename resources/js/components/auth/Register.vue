<template>
  <b-container fluid class="p-0 m-0 w-100">
    <!-- //****** Header Start ********************************************************* */ -->
    <b-row class="wrapper-login">
      <b-col
        class="bg-custom p-5 d-none d-md-block"
        cols="12"
        sm="12"
        md="7"
        lg="8"
      >
        <b-row align-v="end" class="h-100">
          <b-col>
            <h1
              class="login-t title text-white h2 font-weight-bold"
              ref="title-login"
            >
              {{ loginTitle }}
            </h1>
            <p class="paragraph-login text-justify text-white">
              Puedes gestionar tus clientes a tu manera.
            </p>
            <span class="border-down"></span>
          </b-col>
        </b-row>
      </b-col>

      <!-- //****** End *********************************************************************** -->

      <!-- //****** Login Start *********************************************************************** -->
      <b-col class="bg-custom-login p-5" cols="12" sm="12" md="5" lg="4">
        <!-- Alert start -->
        <b-alert
          show
          dismissible
          class="custom-bg-alert text-white"
          v-if="alertError"
        >
          Por favor verifica que todos los campos sean correctos!
        </b-alert>

        <b-alert
          show
          dismissible
          class="custom-bg-alert text-white"
          v-if="credentialError"
        >
          ¡Credenciales Incorrectas, por favor verifica tu correo o contraseña!
        </b-alert>

        <!-- End alert -->
        <div align-h="center" class="pt-4 text-center">
          <div class="d-flex justify-content-center">
            <img
              src="/img/auth/logo-login.png"
              alt="login icon"
              class="mr-3"
              width="150"
            />
          </div>
        </div>
        <br />
        <h2>Registro</h2>

        <div class="mt-4">
          <b-form @submit.prevent="submitHandler" class="login-form" novalidate>
            <b-form-group
              id="fieldset-1"
              label="Nombre"
              label-for="name"
              valid-feedback="El nombre ingresado es valido Gracias!"
              :invalid-feedback="invalidFeedbackName"
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
              id="fieldset-2"
              label="Correo electronico"
              label-for="email"
              valid-feedback="El correo electronico es valido Gracias!"
              :invalid-feedback="invalidFeedbackEmail"
              :state="stateEmail"
              class="font-weight-bold"
            >
              <!-- State: pone el input correcto -->
              <b-form-input
                id="email"
                v-model.trim="formData.email"
                :state="stateEmail"
                trim
                placeholder="Ingresa tu correo"
                maxlength="100"
                class="my-2 p-2"
                type="email"
                autocomplete="off"
              ></b-form-input>
            </b-form-group>

            <b-row align-h="center" class="form-links mt-3">
              <b-col cols="12">
                <a href="/login" class="create-a-account">Iniciar Session</a>
              </b-col>

              <!-- Button Login -->
              <b-col cols="12">
                <b-button-group class="w-80 d-block text-center mt-4 p-2">
                  <button type="submit" class="login-button rounded-pill p-2">
                    Registrarme
                  </button>
                </b-button-group>
              </b-col>
              <!-- End Button Login -->
            </b-row>
          </b-form>
        </div>
      </b-col>
    </b-row>
    <!-- //****** End *********************************************************************** -->
  </b-container>
</template>

<script>
export default {
  data() {
    return {
      loginTitle: "Inicia Sesión y Comienza a Usar Nuestros Servicios",
      alertError: null,
      alertMessage: "",
      dismissSecs: 3,
      dismissCountDown: 0,

      token: document.querySelector('meta[name="csrf-token"]').content,

      credentialError: false,

      formData: {
        name: "",
        email: "",

        validated: {
          name: false,
          email: false,
        },

        regex: {
          email: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        },
      },
    };
  },

  computed: {
    // Validation form
    stateName() {
      return this.formData.name.length > 10
        ? true
        : this.formData.name.length == 0
        ? null
        : false;
    },
    invalidFeedbackName() {
      if (this.formData.name.length <= 10) {
        this.formData.validated.name = false;
        return "Por favor ingresa un nombre valido.";
      }

      this.formData.validated.name = true;
    },

    stateEmail() {
      const {
        email,
        regex: { email: emailRegex },
      } = this.formData;

      return emailRegex.test(email) ? true : email.length > 0 ? false : null;
    },
    invalidFeedbackEmail() {
      if (!this.formData.regex.email.test(this.formData.email)) {
        this.formData.validated.email = false;
        return "El email no es valido!";
      }

      this.formData.validated.email = true;
    },
  },

  methods: {
    async submitHandler() {
      const {
        name: inputName,
        email: inputEmail,
        validated: { name, email },
      } = this.formData;

      if (!name || !email) {
        this.alertError = true;
        setTimeout(() => {
          this.alertError = false;
        }, 3000);
        return;
      }

      this.alertError = false;

      // Hacer peticion http al back-end
      const url = `/send_email`;

      const data = {
        name: inputName,
        email: inputEmail,
        _token: this.token,
      };

      try {
        const result = await axios.get(url, {
          params: {
            name: data.name,
            email: data.email,
          },
        });

        if (result.data.redirect) {
          window.location.replace("/register_user");
        }
      } catch (error) {
        console.log(error);
      }
    },

    countDownChanged(dismissCountDown) {
      this.dismissCountDown = dismissCountDown;
    },
    showAlert() {
      this.dismissCountDown = this.dismissSecs;
    },
  },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&display=swap");
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap");

.wrapper-login {
  width: 100vw;
  height: 100vh;
  min-height: 100vh;
  margin: 0 auto;
}

.bg-custom {
  background-image: linear-gradient(
      120deg,
      rgba(39, 91, 151, 0.3) 0%,
      rgba(39, 92, 151, 0.3) 100%
    ),
    url(/img/auth/login-image.jpg);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
}

.border-down {
  display: block;
  margin: 1rem 0 0 0 !important;
  border-bottom: 2px solid rgba(255, 255, 255, 0.4);
}

.paragraph-login {
  font-size: 0.9rem;
  margin: 1rem 0 2rem 0 !important;
}

.bg-custom-login {
  background-color: #f6fbff;
  padding: 3rem;
}

.login-title {
  font-size: 2rem;
  color: #275c97;
}

.small-subtitle {
  color: #000000;
  font-family: "Roboto", sans-serif;
}

.login-form b-form-group label {
  font-family: "Roboto", sans-serif !important;
  font-weight: 500 !important;
}

.was-validated .form-control:valid:focus,
.form-control.is-valid:focus {
  border: 1px solid #275c97;
  box-shadow: 0 0 0 0.2rem rgb(39 91 151 / 25%);
}

.was-validated .form-control:valid,
.form-control.is-valid {
  border-color: #2c62a0;
  background-image: url(/icons/auth/check-icon.svg);
}

.was-validated .form-control:invalid,
.form-control.is-invalid {
  border-color: #ff3f68;
  padding-right: calc(1.5em + 0.75rem);
  background-image: url(/icons/auth/invalidated-icon.svg);
}

.was-validated .form-control:invalid:focus,
.form-control.is-invalid:focus {
  border-color: #ff5d80;
  box-shadow: 0 0 0 0.2rem rgb(220 53 69 / 25%);
}

.forget-password,
.create-a-account {
  color: #275c97 !important;
  font-size: 0.9rem;
}

.forget-password:hover,
.create-a-account:hover {
  color: #387bc7 !important;
  text-decoration: underline !important;
}

.login-button,
.modal-button {
  width: 60%;
  color: #f6fbff;
  background-color: #275c97;
  border: 2px solid #2c62a0;
}

.login-button:hover,
.modal-button:hover {
  background-color: #23548c;
}

.btn-reset {
  width: 40%;
}

.custom-bg-alert {
  background-color: #ff5d80 !important;
}

input::placeholder {
  color: rgb(175, 175, 175);
  font-size: 0.9em;
}
</style>
