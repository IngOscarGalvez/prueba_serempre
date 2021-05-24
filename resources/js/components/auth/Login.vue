
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
          ¡Por favor, Ingresa todos los campos!
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

        <div class="mt-4">
          <b-form @submit.prevent="submitHandler" class="login-form" novalidate>
            <b-form-group
              id="fieldset-1"
              label="Correo electronico"
              label-for="email"
              :valid-feedback="emailFeedback"
              :invalid-feedback="invalidFeedbackEmail"
              :state="state"
              class="font-weight-bold"
            >
              <!-- State: pone el input correcto -->
              <b-form-input
                id="email"
                v-model.trim="email"
                :state="state"
                trim
                placeholder="Ingresa tu correo"
                maxlength="60"
                class="my-2 p-2"
                type="email"
                autocomplete="off"
              ></b-form-input>
            </b-form-group>

            <b-form-group
              id="fieldset-2"
              label="Contraseña"
              label-for="password"
              :valid-feedback="passFeedback"
              :invalid-feedback="invalidFeedbackPass"
              :state="passwordState"
              class="font-weight-bold"
            >
              <!-- State: pone el input correcto -->
              <b-form-input
                id="password"
                v-model.trim="password"
                :state="passwordState"
                trim
                placeholder="Ingresa tu contraseña"
                maxlength="60"
                class="my-2 p-2"
                type="password"
              ></b-form-input>
            </b-form-group>

            <b-row align-h="center" class="form-links mt-3">
              <b-col cols="6">
                <a href="/register" class="create-a-account">Crear una cuenta</a>

              </b-col>

              <b-col cols="6" class="d-flex flex-row justify-content-end">
                <a v-b-modal.forgetPassword class="forget-password">
                  Cambiar contraseña
                </a>

                <b-modal
                  id="forgetPassword"
                  title="Ingresa tu correo electronico"
                  description="lasdjflkasd"
                  hide-footer
                  centered
                >
                  <div class="p-0 m-0">
                    <header>
                      <p>
                        Por favor revisa tu correo electronico, en unos segundos
                        te enviaremos un nuevo enlace para que puedas reiniciar
                        la contraseña.
                      </p>
                    </header>

                    <main>
                      <b-form>
                        <b-form-group
                          id="fieldset-1"
                          label="Correo electronico"
                          label-for="email"
                          :valid-feedback="emailPassResetFeedback"
                          :invalid-feedback="invalidFeedbackPassReset"
                          :state="emailPassRestState"
                          class="font-weight-bold"
                        >
                          <b-form-input
                            id="email"
                            v-model.trim="emailPassReset"
                            :state="emailPassRestState"
                            trim
                            placeholder="Ingresa tu correo"
                            maxlength="60"
                            class="my-2 p-2"
                            autocomplete="off"
                          ></b-form-input>
                        </b-form-group>

                        <b-button-group
                          class="w-80 d-block text-center mt-4 p-2"
                        >
                          <button
                            class="login-button btn-reset rounded-pill p-2"
                          >
                            Restablecer
                          </button>
                        </b-button-group>
                      </b-form>
                    </main>
                  </div>
                </b-modal>

                <!-- End Modal -->
              </b-col>

              <!-- Button Login -->
              <b-col>
                <b-button-group class="w-80 d-block text-center mt-4 p-2">
                  <button class="login-button rounded-pill p-2">
                    Iniciar Sesión
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
      email: "",
      emailRegex: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
      emailValidated: false,
      emailFeedback: "",
      password: "",
      passRegex: /^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{6,10}$/,
      passValidated: false,
      passFeedback: "",
      loginTitle: "Inicia Sesión y Comienza a Usar Nuestros Servicios",
      alertError: null,
      alertMessage: "",
      dismissSecs: 3,
      dismissCountDown: 0,

      emailPassReset: "",
      emailPassResetFeedback: "",
      emailPassResetValidated: false,
      token: document.querySelector('meta[name="csrf-token"]').content,

      credentialError: false,
    };
  },

  computed: {
    state() {
      if (this.email.length === 0) {
        return null;
      }
      return this.emailValidated === true;
    },

    passwordState() {
      if (this.password.length === 0) {
        return null;
      }
      return this.passValidated === true;
    },

    emailPassRestState() {
      if (this.emailPassReset.length === 0) {
        return null;
      }
      return this.emailPassResetValidated === true;
    },

    invalidFeedbackEmail() {
      if (this.email.length <= 10) {
        this.emailValidated = false;
        return "Por favor ingresa un correo electronico valido";
      } else if (this.email.length > 10 && !this.emailRegex.test(this.email)) {
        this.emailValidated = false;
        return "El correo electronico es invalido, Por favor ingresa un correo electronico real";
      } else {
        this.emailValidated = true;
        this.emailFeedback = "Genial, eso se ve bien.";
        return;
      }
    },

    invalidFeedbackPass() {
      let invalidatedMessage =
        "La contraseña debe tener al menos 6 caracteres y máximo 16, al menos un dígito, una minúscula y una mayúscula.";
      /*
      Contraseña incorrecta: debe tener entre 6 y 10 caracteres, al menos un digito, una minúscula, una mayuscula.
       */
      if (this.password.length <= 5) {
        this.passValidated = false;
        return invalidatedMessage;
      } else if (
        this.password.length >= 6 &&
        this.password.length <= 10 &&
        !this.passRegex.test(this.password)
      ) {
        this.passValidated = false;
        return invalidatedMessage;
      } else if (this.password.length > 10) {
        this.passValidated = false;
        return invalidatedMessage;
      } else {
        this.passValidated = true;
        this.passFeedback =
          "Genial, La contraseña cumple con nuestro estándar de seguridad.";
        return;
      }
    },

    invalidFeedbackPassReset() {
      if (this.emailPassReset.length <= 10) {
        this.emailPassResetValidated = false;
        return "Por favor ingresa un correo electronico valido";
      } else if (
        this.emailPassReset.length > 10 &&
        !this.emailRegex.test(this.emailPassReset)
      ) {
        this.emailPassResetValidated = false;
        return "El correo electronico es invalido, Por favor ingresa un correo electronico real";
      } else {
        this.emailPassResetValidated = true;
        this.emailPassResetFeedback = "Genial, eso se ve bien.";
        return;
      }
    },

    /* transformToUpperCase() {
      const textInArray = this.loginTitle.split(" ");
      let transformText = [];
      for (const word of textInArray) {
        if (word[0] != word[0].toUpperCase()) {
          let modifiedWord = word[0].toUpperCase() + word.substring(1);
          transformText.push(modifiedWord);
        } else {
          transformText.push(word);
        }
      }
      let result = transformText.join(" ");
      return result;
    }, */
  },

  methods: {
    submitHandler() {
      // check if all fields are filled and if they are validated
      if (!this.emailValidated || !this.passValidated) {
        this.alertError = true;
        setTimeout(() => {
          this.alertError = false;
        }, 3000);
        return;
      }

      this.alertError = false;

      // Hacer peticion http al back-end
      const url = `/login`;
      const data = {
        email: this.email,
        password: this.password,
        _token: this.token,
      };

      axios
        .post(url, data)
        .then((res) => {
          console.log(res);
          if (res.data.status == "ok") {
            window.location.href = '/home';
            return;
          }
          // show alert
        })
        .catch((error) => {
          this.credentialError = true;
          setTimeout(() => {
            this.credentialError = false;
          }, 3000);
        });
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
