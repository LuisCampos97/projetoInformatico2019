<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand>
        <img src="../../assets/logo.svg" class="pr-5">Plataforma de Gestão de Contratações
      </b-navbar-brand>

      <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

      <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav class="ml-auto">
          <b-nav-item-dropdown right>
            <template slot="button-content">{{ user.name }}</template>
            <b-dropdown-item v-on:click.prevent="logout">
              <i class="fas fa-sign-out-alt"></i> Logout
            </b-dropdown-item>
          </b-nav-item-dropdown>
        </b-navbar-nav>
      </b-collapse>
    </b-navbar>
    <div class="row no-gutters">
      <div class="col-lg-3 d-none d-sm-block">
        <div class="sidebar-item active">PROPONENTE</div>
        <div class="sidebar-item">DIRETOR DA UO</div>
        <div class="sidebar-item">CONSELHO TÉCNICO-CIENTÍFICO</div>
        <div class="sidebar-item">SECRETARIADO DA DIREÇÃO</div>
        <div class="sidebar-item">RECURSOS HUMANOS</div>
      </div>
      <div class="col-lg-9">
        <div class="main">
          <button class="btn btn-success mb-4 font-weight-bold" v-on:click.prevent="novaProposta"
           v-if="isDashboardVisible && user.roleDB == 'proponente'">
            <i class="fas fa-plus"></i> Nova Proposta
          </button>
          <separator-table v-if="isDashboardVisible"></separator-table>
          <proponente v-if="isNovaPropostaVisible"></proponente>
          <tabela-ctc v-if="user.roleDB == 'ctc'"></tabela-ctc>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
module.exports = {
  data: function() {
    return {
      isDashboardVisible: true,
      isNovaPropostaVisible: false
    };
  },
  methods: {
    logout() {
      axios.post("api/logout").then(response => {
        this.$store.commit("clearUserAndToken");
        this.$router.push({
          name: "login"
        });
      });
    },
    novaProposta() {
      //* Componente Proponente fica visivel
      this.isNovaPropostaVisible = true;
      this.isDashboardVisible = false;
    }
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  },
  mounted() {
  },
};
</script>

<style lang="scss">
//* NAVBAR
.navbar-brand {
  font-size: 30px;
  font-weight: 300;
}

.navbar {
  border-bottom: 1px solid gray;
}

//* SIDEBAR
.sidebar-item {
  color: #1f1f1f;
  background-color: #f5f5f5;
  font-weight: 600;
  font-size: 20px;
  vertical-align: middle;
  text-align: center;
  padding: 70px;
  border-bottom: 1px solid white;
  border-top: 1px solid white;
}

.sidebar-item.active {
  background-color: #1f1f1f;
  color: white;
}

//* MAIN
.main {
  margin: 40px;
}
</style>
