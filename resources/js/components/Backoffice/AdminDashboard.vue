<template>
      <div class="page">
      <!-- Main Navbar-->
      <header class="header">
        <nav class="navbar">
          <div class="container-fluid">
            <div class="navbar-holder d-flex align-items-center justify-content-between">
              <!-- Navbar Header-->
              <div class="navbar-header">
                <!-- Navbar Brand --><a href="index.html" class="navbar-brand">
                  <div class="brand-text brand-big"><span>Admin </span><strong>Dashboard</strong></div>
                  <div class="brand-text brand-small"><strong>BD</strong></div></a>
                <!-- Toggle Button--><a id="toggle-btn" href="#" class="menu-btn active"><span></span><span></span><span></span></a>
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
              <h1 class="h4">Zé Manel</h1>
              <p>admin</p>
            </div>
          </div>
          <!-- Sidebar Navidation Menus-->
          <span class="heading">MENU</span>
          <ul class="list-unstyled">
            <li class="active"><a href="index.html"> <i class="icon-home"></i>Home </a></li>
            <li><a href="tables.html"> <i class="icon-grid"></i>Tables </a></li>
            <li><a href="charts.html"> <i class="fa fa-bar-chart"></i>Charts </a></li>
            <li><a href="forms.html"> <i class="icon-padnote"></i>Forms </a></li>
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
                      <div class="progress">
                        <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{ numeroUtilizadores }}</strong></div>
                  </div>
                </div>
                <!-- Item -->
                <div class="col-xl-6 col-sm-6">
                  <div class="item d-flex align-items-center">
                    <div class="icon bg-red"><i class="icon-padnote"></i></div>
                    <div class="title"><span>Número de<br>Propostas</span>
                      <div class="progress">
                        <div role="progressbar" style="width: 70%; height: 4px;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                      </div>
                    </div>
                    <div class="number"><strong>{{ numeroPropostas }}</strong></div>
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
                    <div class="card-close">
                      <div class="dropdown">
                        <button type="button" id="closeCard1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard1" class="dropdown-menu dropdown-menu-right has-shadow"><a href="#" class="dropdown-item remove"> <i class="fa fa-times"></i>Close</a><a href="#" class="dropdown-item edit"> <i class="fa fa-gear"></i>Edit</a></div>
                      </div>
                    </div>
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
//require('./../../front.js');
export default {
  data() {
    return {
      numeroUtilizadores: 0,
      numeroPropostas: 0,
      utilizadores: []
    }
  },
  methods: {
    logout() {
      console.log("LOGOUT");
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
}
</script>

<style lang="scss">
  @import "../../../styles/fontastic.css";
  @import "../../../styles/style.default.css";
  @import "../../../styles/style.blue.css";
</style>

