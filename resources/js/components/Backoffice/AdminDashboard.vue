<template>
      <div class="page">
        <loading :active.sync="isLoading"
        :width="150" :height="150"></loading>
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a class="navbar-brand">
                  <div class="brand-text brand-big"><span>Admin </span><strong>Dashboard</strong></div>
                  <div class="brand-text brand-small"><strong>AD</strong></div></a>
              </div>
              <!-- Navbar Menu -->
              <ul class="nav-menu list-unstyled d-flex flex-md-row align-items-md-center">
                <!-- Logout    -->
                <li class="nav-item"><a class="nav-link logout" v-on:click.prevent="logout">Logout<i class="fa fa-sign-out"></i></a></li>
              </ul>
            </div>
          </div>
        </nav>
      </header>
      <div class="page-content d-flex align-items-stretch"> 
        <!-- Side Navbar -->
        <nav class="side-navbar">
          <!-- Sidebar Header-->
          <div class="sidebar-header d-flex align-items-center">
            <div class="title">
              <h1 class="h4">{{ user.name }}</h1>
              <p>{{ user.role }}</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus-->
          <span class="heading">Menu</span>
          <ul class="list-unstyled">
            <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>
          </ul>
        </nav>
        <div class="content-inner">
          <!-- Page Header-->
          <header class="page-header">
            <div class="container-fluid">
              <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
          </header>
          <!-- Dashboard Counts Section-->
          <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
              <div class="row bg-white has-shadow">
                <!-- Item -->
                <div class="col-xl-6 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-violet"><i class="icon-user"></i></div>
                    <div class="title"><span>Número de<br>Utilizadores</span>
                    </div>
                    <div class="number"><strong>{{ numeroUtilizadores }}</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-6 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-padnote"></i></div>
                    <div class="title"><span>Número de<br>Propostas</span>
                    </div>
                    <div class="number"><strong>{{ numeroPropostas }}</strong></div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section>
            <div class="container-fluid">
              <div class="row">
                <div class="col">
                  <div class="card">
                <button class="btn btn-primary" v-on:click.prevent="carregar">Carregar Cursos e UCs</button>
                <br />
                <button class="btn btn-primary" @click="adicionarCurso">Adicionar Curso</button>
                <adicionar-curso v-on:fecharCurso="fecharCurso" v-if="mostrarCompAddCurso"></adicionar-curso>
                <br />
                <button class="btn btn-primary" v-on:click.prevent="adicionarUC">Adicionar UC</button>
                <adicionar-ucs v-on:fecharUcs="fecharUcs" v-if="mostrarCompAddUC"></adicionar-ucs>
              </div>
                </div>
              </div>
            </div>
          </section>
          
          <section class="dashboard-header">
            <div class="container-fluid">
              <div class="row">
                <div class="col-lg">
                  <div class="card">
                    <div class="card-header d-flex align-items-center">
                      <h3 class="h4">Lista de Utilizadores</h3>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table">
                          <thead>
                            <tr>
                              <th>#</th>
                              <th>Nome</th>
                              <th>Email</th>
                              <th>Role</th>
                              <th>Role secundária</th>
                              <th>Unidade Orgânica</th>
                              <th>Ações</th>
                            </tr>
                          </thead>
                          <tbody v-for="user in utilizadores" :key="user.id">
                            <tr>
                              <th>{{user.id}}</th>
                              <td>{{user.name}}</td>
                              <td>{{user.email}}</td>
                              <td>{{user.role}}</td>
                              <td>{{user.roleDB}}</td>
                              <td>{{user.unidade_organica}}</td>
                              <td>
                                <button v-if="user.id != $store.state.user.id"
                                 class="btn btn-primary btn-sm" v-on:click.prevent="editar(user.id)">Editar</button>
                                 <button v-if="user.id != $store.state.user.id && user.blocked == 0"
                                 class="btn btn-danger btn-sm" v-on:click.prevent="bloquearUtilizador(user.id)">Bloquear</button>
                                 <button v-if="user.id != $store.state.user.id && user.blocked == 1"
                                 class="btn btn-success btn-sm" v-on:click.prevent="desbloquearUtilizador(user.id)">Desbloquear</button>

                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>

</template>

<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

export default {
  data() {
    return {
      isLoading: false,
      numeroUtilizadores: 0,
      numeroPropostas: 0,
      utilizadores: [],
      role: '',
      mostrarCompAddCurso:false,
      mostrarCompAddUC:false
    }
  },
  components: {
    Loading
  },
  methods: {
    adicionarCurso(){
      this.mostrarCompAddCurso = true;
      this.mostrarCompAddUC = false;
    },

    adicionarUC(){
      this.mostrarCompAddUC = true;
      this.mostrarCompAddCurso = false;
    },

    fecharCurso(){
      this.mostrarCompAddCurso = false;
    },

    fecharUcs(){
      this.mostrarCompAddUC = false;
    },

    logout() {
      axios.post("api/logout").then(response => {
        this.$store.commit("clearUserAndToken");
        this.$router.push({
          name: "adminLogin"
        });
      });
    },
    carregarUtilizadores() {
      axios.get("api/users").then(response => {
        this.utilizadores = response.data;
        this.numeroUtilizadores = response.data.length;
      });
    },
    carregar() {
      this.isLoading = true;
      axios.get("api/lerCursosEUcs").then(response => {
        this.isLoading = false;
        this.$swal('Sucesso', response.data, 'success');
      });
    },
    editar(id) {
      const { value: role } = this.$swal({
          title: 'Escolha a role para que pretende alterar?',
          input: 'select',
          inputPlaceholder: 'Escolha uma role',
          showCancelButton: true,
          inputOptions: {
            proponente_departamento: 'Proponente (Departamento)',
            proponente_curso: 'Proponente (Curso)',
            diretor_uo: 'Diretor da UO',
            ctc: 'CTC',
            secretariado_direcao: 'Secretariado da Direção',
            recursos_humanos: 'Recursos Humanos',
            docente_temp: 'Docente Temporário',
            admin: 'Admin'
          },
          inputValidator: (value) => {
            return new Promise((resolve) => {
              if(value) {
                this.updateRole(id, value);
                this.carregarUtilizadores();
                resolve();
              } else {
                resolve('É necessário selecionar uma role');
              }
              
            })
          }
        });

    },
    updateRole(id, role) {
      axios.put("api/users/updateRole/"+id, role).then(response => {   
      });
    },
    bloquearUtilizador(userID){
      axios.put('/api/block/' + userID).then(response => {
        axios.get("api/users").then(response => {
        this.utilizadores = response.data;
        this.numeroUtilizadores = response.data.length;
    });
      });
    },
    desbloquearUtilizador(userID){
      axios.put('/api/unblock/' + userID).then(response => {
        axios.get("api/users").then(response => {
        this.utilizadores = response.data;
        this.numeroUtilizadores = response.data.length;
    });
      });
      
    }
  },
  mounted() {
    axios.get("api/users").then(response => {
        this.utilizadores = response.data;
        this.numeroUtilizadores = response.data.length;
    });

    axios.get("api/propostas").then(response => {
      this.numeroPropostas = response.data.length;
    });
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  },
}
</script>

<style lang="scss" scoped>
  @import "../../../styles/fontastic.css";
  @import "../../../styles/style.default.css";
  @import "../../../styles/style.blue.css";

  .nav-link.logout {
    cursor: pointer;
  }
</style>

