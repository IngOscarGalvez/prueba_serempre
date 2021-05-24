<template>
  <div class="container-background-custom">
    <form class="form-backgroun-custom" @submit.prevent="handlerSubmit">
      <h1 class="h5 text-center font-weight-bold mb-3">
        Por favor verifica tú correo para continuar con el registro
      </h1>
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

      <b-form-group
        id="fieldset-3"
        label="Token de seguridad"
        label-for="token"
        valid-feedback="El Token es valido!"
        :invalid-feedback="invalidFeedbackToken"
        :state="stateToken"
        class="font-weight-bold"
      >
        <!-- State: pone el input correcto -->
        <b-form-input
          id="token"
          v-model.trim="formData.token"
          :state="stateToken"
          trim
          placeholder="Ingresa tu correo"
          maxlength="10"
          class="my-2 p-2"
          type="text"
          autocomplete="off"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="fieldset-4"
        label="Ingresar contraseña"
        label-for="pass"
        valid-feedback="La contraseña es valida Gracias!"
        :invalid-feedback="invalidFeedbackPass"
        :state="statePass"
        class="font-weight-bold"
      >
        <!-- State: pone el input correcto -->
        <b-form-input
          id="pass"
          v-model.trim="formData.pass"
          :state="statePass"
          trim
          placeholder="Ingresa tu contraseña"
          maxlength="10"
          class="my-2 p-2"
          type="password"
          autocomplete="off"
        ></b-form-input>
      </b-form-group>

      <b-form-group
        id="fieldset-5"
        label="Confirmar contraseña"
        label-for="confirm-pass"
        valid-feedback="La contraseña es valida Gracias!"
        :invalid-feedback="invalidFeedbackConfirmPass"
        :state="stateConfirmPass"
        class="font-weight-bold"
      >
        <!-- State: pone el input correcto -->
        <b-form-input
          id="confirm-pass"
          v-model.trim="formData.confirmPass"
          :state="stateConfirmPass"
          trim
          placeholder="Ingresa tu contraseña"
          maxlength="10"
          class="my-2 p-2"
          type="password"
          autocomplete="off"
        ></b-form-input>
      </b-form-group>

      <b-form-group>
        <button type="submit" class="btn btn-success form-control">
          Crear Cuenta
        </button>
      </b-form-group>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      formData: {
        email: "",
        token: "",
        pass: "",
        confirmPass: "",

        validated: {
          email: false,
          token: false,
          pass: false,
        },

        regex: {
          email: /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
        },

        alertError: false,
      },
    };
  },

  methods: {
    async handlerSubmit() {
      const {
        email,
        token,
        pass,
        validated: {
          email: emailValidation,
          token: tokenValidation,
          pass: passValidation,
        },
      } = this.formData;

      if (!emailValidation || !tokenValidation || !passValidation) {
        this.formData.alertError = true;
        setTimeout(() => {
          this.formData.alertError = false;
        }, 300);
      }

      this.formData.alertError = false;

      // send request
      try {
        const url = "/register_user_validated";
        const result = await axios.get(url, {
          params: {
            email,
            token,
            pass,
          },
        });

        if (result.data.redirect) {
          window.location.replace("/login");
        }
      } catch (error) {
        console.log(error);
      }
    },
  },

  computed: {
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

    stateToken() {
      const { token } = this.formData;

      return token.length == 10 ? true : token.length == 0 ? null : false;
    },
    invalidFeedbackToken() {
      if (!this.formData.token.length == 10) {
        this.formData.validated.token = false;
        return "El token no es valido, por favor verifica el token enviado a tú email";
      }

      this.formData.validated.token = true;
    },

    statePass() {
      const { pass } = this.formData;

      return pass.length > 7 ? true : pass.length == 0 ? null : false;
    },
    invalidFeedbackPass() {
      return "La contraseña debe tener más de 7 caracteres";
    },

    stateConfirmPass() {
      const { pass, confirmPass } = this.formData;

      if (confirmPass.length > 7) {
        if (confirmPass == pass) {
          this.formData.validated.pass = true;
          return true;
        }
        this.formData.validated.pass = false;
        return false;
      } else {
        if (confirmPass.length == 0) {
          this.formData.validated.pass = false;
          return null;
        } else {
          this.formData.validated.pass = false;
          return false;
        }
      }
    },
    invalidFeedbackConfirmPass() {
      return "Las contraseñas no coinciden, por favor verifica!";
    },
  },
};
</script>

<style scoped>
.container-background-custom {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100vw;
  height: 100vh;
  background-image: linear-gradient(to right, #4facfe 0%, #00f2fe 100%);
}

.form-backgroun-custom {
  width: 350px;
  height: auto;
  padding: 1rem;
  background-color: rgb(255, 255, 255);
  border-radius: 5px;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.296);
}
</style>
