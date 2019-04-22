<template>
  <div id="wrapper">
    <div id="welcome">
      <h1 id="logo">
        <a href="https://ead.ipleiria.pt/2018-19">
          <img
            src="https://ead.ipleiria.pt/2018-19/theme/image.php/ead/theme/1554110091/logo-white"
            alt="Politécnico de Leiria"
            width="260"
            height="80"
          >
        </a>
      </h1>
      <div id="app-name">
        <div>Plataforma de</div>
        <div class="main-title">Gestão de Contrações</div>
        <div></div>
        <div class="year">2018.19</div>
      </div>
    </div>
    <div id="login-form">
      <div class="form-label">
        <label for="inputEmail">Nome de utilizador</label>
      </div>
      <div class="form-input">
        <input type="email" name="email" v-model.trim="user.email" id="inputEmail">
      </div>
      <div class="clearer"></div>
      <div class="form-label">
        <label for="inputPassword">Senha</label>
      </div>
      <div class="form-input">
        <input type="password" name="password" id="inputPassword" v-model.trim="user.password">
      </div>

      <div class="clearer"></div>
      <div class="rememberpass">
        <input type="checkbox" name="rememberusername" id="rememberusername" value="1">
        <label for="rememberusername">Lembrar nome de utilizador</label>
      </div>
      <div class="clearer"></div>
      <input id="anchor" type="hidden" name="anchor" value>
      <input type="hidden" name="logintoken" value="xXmFcR9IcSorlXUxa11eH1rHtkJ13afg">
      <input type="submit" id="loginbtn" value="Entrar" v-on:click.prevent="login">
      <a class="btn btn-primary" v-on:click.prevent="login">Login</a>
      <div class="forgetpass">
        <a
          href="https://ead.ipleiria.pt/2018-19/login/forgot_password.php"
        >Esqueceu-se do seu nome de utilizador ou da senha?</a>
      </div>
    </div>

    <button
      type="button"
      class="btn btn-success"
      style="float:right"
      @click="showProponenteView"
    >Proponente</button>
    <button
      type="button"
      class="btn btn-warning"
      style="float:right"
      @click="showDiretorView"
    >Diretor UO</button>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      user: {
        email: "",
        password: ""
      }
    };
  },
  methods: {
    login() {
      axios.post("api/login", this.user).then(response => {
        console.log(response);
      });
    },
    showProponenteView() {
      this.$router.push({ name: "proponente" });
    },
    showDiretorView(){
      this.$router.push({ name: "vistaPropostasGeralDiretor" });
    }
  }
};
</script>

<style>
#wrapper {
  display: table;
  overflow: hidden;
  position: absolute;
  z-index: 0;
  width: 100%;
  height: 100%;
}

body {
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
  line-height: 18px;
  color: #676a6c;
}

#welcome,
#login-form {
  display: table-cell;
  width: 50%;
  height: 100%;
  vertical-align: top;
}

/* Welcome */
#welcome {
  background-color: #1a1a1a;
  background-size: cover;
  color: white;
  vertical-align: middle;
}

#app_name,
#logo {
  padding: 20px 0 0;
  position: relative;
  text-align: center;
  margin: 0;
}

#app-name {
  text-align: center;
  line-height: 3.5rem;
  font-size: 2.2rem;
  letter-spacing: 0.5rem; /* Retificar para ver como fica melhor */
  padding: 70px 0 60px;
}

.main-title,
.year {
  font-weight: 700;
}

/* Login Form */
#login-form {
  max-width: 400px;
  margin: 0 auto;
  vertical-align: middle;
  text-align: center;
}

.form-input,
.form-label {
  float: none;
  text-align: center;
}

input {
  border: 1px solid #ccc;
  width: 50%;
}

.form-label label {
  font-weight: 700;
}
</style>
