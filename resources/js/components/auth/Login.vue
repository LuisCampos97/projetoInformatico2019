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
      <input id="anchor" type="hidden" name="anchor" value>
      <input type="hidden" name="logintoken" value="xXmFcR9IcSorlXUxa11eH1rHtkJ13afg">
      <input type="submit" id="loginbtn" value="Entrar" v-on:click.prevent="login">
    </div>

    <!-- <button
      type="button"
      class="btn btn-success"
      style="float:right"
      @click="showProponenteView"
    >Proponente</button>-->
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
    }
  }
};
</script>

<style>
#wrapper {
  display: table;
  overflow: hidden;
  position: absolute;
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
  width: 100%;
  vertical-align: middle;
  text-align: center;
}

.form-input,
.form-label {
  float: none;
}

input {
  border: 1px solid #ccc;
  width: 45%;
  font-weight: 400;
  vertical-align: middle;
}

.form-label label {
  font-weight: 700;
}

.clearer {
  background: 0 0;
  border-width: 0;
  clear: both;
  height: 1px;
  margin: 0;
  padding: 0;
}

.form-input input,
#loginbtn {
  padding: 10px;
}

#loginbtn {
  background: #ef4758;
  color: #fff;
  font-weight: 700;
  text-shadow: none;
  cursor: pointer;
  margin-top: 15px;
}

label {
  margin-bottom: 5px;
  display: inline-block;
  float: none;
  margin-top: 15px;
}

</style>
