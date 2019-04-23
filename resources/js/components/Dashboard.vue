<template>
  <div class="grid-container">
    <ul class="navbar">
      <li class="navbar-logo" href="#">
        <img src="https://ead.ipleiria.pt/2018-19/theme/image.php/ead/theme/1554110091/logo-white">
      </li>
      <li>
        <div class="navbar-name">Plataforma de Gestão de Contratações</div>
      </li>
      <li>
        <a class="navbar-user" v-on:click.prevent="logout">Logout</a>
      </li>
    </ul>
    <div class="sidebar">
      <div class="sidebar-item active">PROPONENTE</div>
      <div class="sidebar-item">DIRETOR DA UO</div>
      <div class="sidebar-item">CONSELHO TÉCNICO-CIENTÍFICO</div>
      <div class="sidebar-item">SECRETARIADO DA DIREÇÃO</div>
      <div class="sidebar-item">RECURSOS HUMANOS</div>
    </div>
    <div class="main">
      <proponente></proponente>
    </div>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {};
  },
  methods: {
    logout() {
      axios.post("api/logout").then(response => {
        this.$store.commit("clearUserAndToken");
        this.$router.push({
          name: "login"
        });
      });
    }
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  }
};
</script>

<style>
body {
  font-family: "Open Sans", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 13px;
  line-height: 18px;
  color: black;
}

.grid-container {
  display: grid;
  grid-template-areas:
    "navbar navbar"
    "sidebar main";
  grid-template-columns: 20% auto;
  grid-template-rows: auto;
}

/* NAVBAR */
.navbar {
  grid-area: navbar;
  background-color: #1b1b1b;
}

ul.navbar {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
}

li a {
  padding: 14px 16px;
  text-decoration: none;
  color: white;
}

/* Change the link color to #111 (black) on hover */
li a:hover {
  background-color: #111;
  text-decoration: none;
  color: white;
}

.navbar-logo img {
  padding: 20px 0px 20px 25px;
}

div.navbar-name {
  color: white;
  font-size: 30px;
  font-weight: 600;
}

a.navbar-user {
  font-size: 15px;
  color: white;
}

/* SIDEBAR */
.sidebar {
  grid-area: sidebar;
  background-color: #676a6c;
}

.sidebar-item {
  color: white;
  font-size: 20px;
  vertical-align: middle;
  text-align: center;
  padding: 75px;
  border-bottom: 1px solid white;
  border-top: 1px solid white;
}

.sidebar-item.active {
  background-color: #1b1b1b;
}

.main {
  grid-area: main;
  padding: 10px;
}
</style>
