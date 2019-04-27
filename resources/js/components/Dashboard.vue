<template>
  <div class="grid-container">
      <b-navbar toggleable="lg" type="light" variant="light">
        <b-navbar-brand>
          <img src="../../assets/logo.svg">Plataforma de Gestão de Contratações
        </b-navbar-brand>
        
        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
          <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown right>
              <template slot="button-content">User</template>
              <b-dropdown-item v-on:click.prevent="logout">Logout</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
    <div class="sidebar">
      <div class="sidebar-item active">PROPONENTE</div>
      <div class="sidebar-item">DIRETOR DA UO</div>
      <div class="sidebar-item">CONSELHO TÉCNICO-CIENTÍFICO</div>
      <div class="sidebar-item">SECRETARIADO DA DIREÇÃO</div>
      <div class="sidebar-item">RECURSOS HUMANOS</div>
    </div>
    <div class="main">
      <separator-table></separator-table>
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

<style lang="scss" scoped>
@import "../../sass/app.scss";

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
  grid-template-columns: 24rem auto;
  grid-template-rows: auto;
}

/* NAVBAR */
.navbar {
  grid-area: navbar;
  background-color: #f5f5f5;
  border-bottom: 1px solid gray;
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
  color: #1a1a1a;
}

li a:hover {
  background-color: #f5f5f5;
  text-decoration: none;
}

li.logo {
  background-color: #f5f5f5;
  list-style-type: none;
  border-bottom: 1px solid gray;
}

.logo img {
  padding: 20px 0px 20px 25px;
}

div.navbar-name {
  font-size: 30px;
  font-weight: 300;
  padding-left: 18rem;
}

a.navbar-user {
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  margin-right: 15px;
  color: #1a1a1a;
}

/* SIDEBAR */
.sidebar {
  grid-area: sidebar;
  background-color: #f5f5f5;
}

.sidebar-item {
  color: #1f1f1f;
  font-weight: 600;
  font-size: 20px;
  vertical-align: middle;
  text-align: center;
  padding: 75px;
  border-bottom: 1px solid white;
}

.sidebar-item.active {
  background-color: $backgroud-color;
  color: white;
}

.main {
  grid-area: main;
  padding: 10px;
}
</style>
