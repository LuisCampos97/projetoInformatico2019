<template>
  <div class="wrapper row no-gutters">
    <loading :active.sync="isLoading"
        :width="150" :height="150"></loading>
    <div class="col-md-6 welcome">
      <div class="wrapper row no-gutters align-items-center">
        <div class="col">
          <a>
            <img
              src="https://ead.ipleiria.pt/2018-19/theme/image.php/ead/theme/1554110091/logo-white"
              alt="Politécnico de Leiria"
              width="260"
              height="80"
            >
          </a>
          <div class="app-name pt-5">
            <div class="font-weight-lighter">Plataforma de</div>
            <div class="font-weight-bold">Gestão de Contratações</div>
            <div class="font-weight-bold">2018.19</div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="wrapper row no-gutters align-items-center teste">
        <div class="col-md-6 login_form">
          <b-alert show variant="dark" v-show="error">{{ errorMessage }}</b-alert>
          <div class="form-group">
            <label for="inputEmail" class="font-weight-bold">Nome de utilizador</label>
            <b-form-input id="inputEmail" v-model="user.email" v-on:keyup.enter="login" trim></b-form-input>
          </div>
          <div class="form-group">
            <label for="inputPassword" class="font-weight-bold">Senha</label>
            <b-form-input type="password" id="inputPassword" v-model="user.password" v-on:keyup.enter="login" trim></b-form-input>
          </div>
          <b-button class="col-md-12" variant="dark" v-on:click.prevent="login">Entrar</b-button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  data: function() {
    return {
      isLoading: false,
      error: false,
      errorMessage: "",
      user: {
        email: "",
        password: ""
      }
    };
  },
  components: {
            Loading
        },
  methods: {
    login() {
      this.isLoading = true;
      this.error = false;
      axios
        .post("api/login", this.user)
        .then(response => {
          this.$store.commit("setToken", response.data.token);
          this.$store.commit("setUser", response.data.user);
          this.isLoading = false;
          this.$router.push({ name: "dashboard" });
        })
        .catch(error => {
          this.error = true;
          this.isLoading = false;
          this.errorMessage = Object.values(error.response.data)[0];
        });
    },
    showProponenteView() {
      this.$router.push({ name: "proponente" });
    }
  }
};
</script>

<style scoped>
.wrapper {
  width: 100%;
  height: 100%;
  position: absolute;
  align-self: center;

  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
}

/* Welcome */
.welcome {
  background-color: #1a1a1a;
  background-size: cover;
  color: white;
  text-align: center;
}

.app-name {
  line-height: 3.5rem;
  font-size: 2.2rem;
  letter-spacing: 0.5rem;
}

/* Login Form */
.login_form {
  margin: 0 14vw;
  font-family: "Montserrat", sans-serif;
  align-items: center;
}

.form-control:focus {
  color: #495057;
  background-color: #fff;
  border-color: #1a1a1a;
  outline: 0;
  box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
}

.clas

.btn-dark {
  color: #fff;
  background-color: #1a1a1a;
  border-color: #1a1a1a;
}

label {
  font-size: 13px;
}

.alert-dark {
  text-align: center;
  padding: 20px;
}
</style>
