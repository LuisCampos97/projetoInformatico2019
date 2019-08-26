<template>
  <div>
    <b-navbar toggleable="lg" type="light" variant="light">
      <b-navbar-brand>
        <img src="../../assets/logo.svg" class="pr-5" @click="home">Plataforma de Gestão de Contratações
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
      <div class="col-lg-3 d-md-none d-lg-block">
        <div class="sidebar-item" v-bind:class="{ active: isActiveProponente }">PROPONENTE</div>
        <div class="sidebar-item" v-bind:class="{ active: isActiveDiretorUO }">DIRETOR DA UO</div>
        <div class="sidebar-item" v-bind:class="{ active: isActiveCTC }">CONSELHO TÉCNICO-CIENTÍFICO</div>
        <div class="sidebar-item" v-bind:class="{ active: isActiveSD }">SECRETARIADO DA DIREÇÃO</div>
        <div class="sidebar-item" v-bind:class="{ active: isActiveRH }">RECURSOS HUMANOS</div>
      </div>
      <div class="col-lg-9">
        <div class="main">
          <button
            class="btn btn-success mb-4 font-weight-bold"
            v-on:click.prevent="novaProposta"
            v-if="isDashboardVisible && (this.$store.state.user.roleDB == 'proponente_departamento'
            ||this.$store.state.user.roleDB == 'proponente_curso')"
          >
            <i class="fas fa-plus"></i> Nova Proposta
          </button>

          <tabela-diretor v-if="isDashboardVisible"></tabela-diretor>
          <proponente v-if="isNovaPropostaVisible" v-on:voltar="mostrarProponentes"></proponente>
          <tabela-ctc v-if="user.roleDB == 'ctc'"></tabela-ctc>
          <tabela-secretariado v-if="user.roleDB == 'secretariado_direcao'"></tabela-secretariado>
          <ficheiros-docente v-if="user.roleDB == 'docente_temp'"></ficheiros-docente>
          <tabela-recursos v-if="user.roleDB == 'recursos_humanos'"></tabela-recursos>
          <resumo-geral v-if="isResumoPropostaVisible" :propostaSelecionada="propostaSelecionada"
            v-on:mostrarProponentes="mostrarProponentes"></resumo-geral>

          <div v-if="mostrarTabela">
            <div v-if="user.roleDB == 'proponente_departamento' && !isNovaPropostaVisible">
              COORDENADOR DEPARTAMENTO
              <div class="separator">
                <b-tabs content-class="mt-3" align="left">
                  <b-tab title="Propostas Pendentes" active>
                    <table class="table">
                      <thead>
                        <th>Nome docente a ser contratado</th>
                        <th>Tipo contrato</th>
                        <th>Unidade Organica</th>
                        <th>Role</th>
                        <th>Ações</th>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(propostaPendenteDiretorDepartamento, index) in propostasPendentesCoordenadorDepartamento"
                          :key="propostaPendenteDiretorDepartamento.id"
                        >
                          <td>{{ propostaPendenteDiretorDepartamento.nome_completo }}</td>
                          <td>{{ propostaPendenteDiretorDepartamento.tipo_contrato }}</td>
                          <td>{{ propostaPendenteDiretorDepartamento.role }}</td>
                          <td>{{ propostaPendenteDiretorDepartamento.unidade_organica }}</td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-info"
                              @click="verDetalhesCoordenadorDepartamento(propostaPendenteDiretorDepartamento, index)"
                            >Ver detalhes</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </b-tab>
                  <b-tab title="Histórico de Propostas">
                    <table class="table">
                      <thead>
                        <th>Nome docente a ser contratado</th>
                        <th>Tipo contrato</th>
                        <th>Unidade Organica</th>
                        <th>Ações</th>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(propostaHistorico, index) in historicoPropostasCoordenadorDepartamento"
                          :key="propostaHistorico.id"
                        >
                          <td>{{ propostaHistorico.nome_completo }}</td>
                          <td>{{ propostaHistorico.tipo_contrato }}</td>
                          <td>{{ propostaHistorico.unidade_organica }}</td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-info"
                              @click="verDetalhesCoordenadorDepartamento(propostaHistorico, index)"
                            >Ver detalhes</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </b-tab>
                </b-tabs>
              </div>
            </div>

            <br />
            <div v-if="user.roleDB == 'proponente_curso' && !isNovaPropostaVisible">
              COORDENADOR CURSO
              <div class="separator">
                <b-tabs content-class="mt-3" align="left">
                  <b-tab title="Propostas Pendentes" active>
                    <table class="table">
                      <thead>
                        <th>Nome docente a ser contratado</th>
                        <th>Tipo contrato</th>
                        <th>Unidade Organica</th>
                        <th>Role</th>
                        <th>Ações</th>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(propostaPendenteCoordenadorCurso, index) in propostasPendentesCoordenadorCurso"
                          :key="propostaPendenteCoordenadorCurso.id"
                        >
                          <td>{{ propostaPendenteCoordenadorCurso.nome_completo }}</td>
                          <td>{{ propostaPendenteCoordenadorCurso.tipo_contrato }}</td>
                          <td>{{ propostaPendenteCoordenadorCurso.unidade_organica }}</td>
                          <td>{{ propostaPendenteCoordenadorCurso.role }}</td>

                          <td>
                            <button
                              type="button"
                              class="btn btn-info"
                              @click="verDetalhesCoordenadorCurso(propostaPendenteCoordenadorCurso, index)"
                            >Ver detalhes</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </b-tab>
                  <b-tab title="Histórico de Propostas">
                    <table class="table">
                      <thead>
                        <th>Nome docente a ser contratado</th>
                        <th>Tipo contrato</th>
                        <th>Role</th>
                        <th>Unidade Organica</th>
                        <th>Ações</th>
                      </thead>
                      <tbody>
                        <tr
                          v-for="(propostaHistorico, index) in historicoPropostasCoordenadorCurso"
                          :key="propostaHistorico.id"
                        >
                          <td>{{ propostaHistorico.nome_completo }}</td>
                          <td>{{ propostaHistorico.tipo_contrato }}</td>
                          <td>{{ propostaHistorico.role }}</td>
                          <td>{{ propostaHistorico.unidade_organica }}</td>
                          <td>
                            <button
                              type="button"
                              class="btn btn-info"
                              @click="verDetalhesCoordenadorCurso(propostaHistorico, index)"
                            >Ver detalhes</button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </b-tab>
                </b-tabs>
              </div>
            </div>
          </div>
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
      isNovaPropostaVisible: false,
      isActiveProponente: false,
      isActiveDiretorUO: false,
      isActiveCTC: false,
      isActiveSD: false,
      isActiveRH: false,
      propostasPendentesCoordenadorDepartamento: "",
      historicoPropostasCoordenadorDepartamento: "",
      propostasPendentesCoordenadorCurso: "",
      historicoPropostasCoordenadorCurso: "",
      isResumoPropostaVisible: false,
      propostaSelecionada: "",
      mostrarTabela: true,
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
    },
    home() {
      this.isDashboardVisible = true;
      this.isNovaPropostaVisible = false;
    },
    verDetalhesCoordenadorCurso(propostaPendenteCoordenadorCurso, index) {
      this.isResumoPropostaVisible = true;
      this.isDashboardVisible = false;
      this.propostaSelecionada = Object.assign(
        {},
        propostaPendenteCoordenadorCurso
      );
      this.mostrarTabela = false;
      this.isDashboardVisible = false;
    },
    verDetalhesCoordenadorDepartamento(
      propostaPendenteCoordenadorDepartamento,
      index
    ) {
      this.isResumoPropostaVisible = true;
      this.isDashboardVisible = true;
      this.propostaSelecionada = Object.assign(
        {},
        propostaPendenteCoordenadorDepartamento
      );
      this.mostrarTabela = false;
      this.isDashboardVisible = false;
    },
    mostrarProponentes() {
      this.isNovaPropostaVisible = false;
      this.mostrarTabela = true;
      this.isResumoPropostaVisible = false;
      this.isDashboardVisible = true;
      if(this.$store.state.user.roleDB == 'proponente_departamento'){
      axios
        .get("/api/coordenadorDepartamento/propostasPendentes")
        .then(response => {
          this.propostasPendentesCoordenadorDepartamento = response.data;
        });
      axios
        .get("/api/coordenadorDepartamento/historicoPropostas")
        .then(response => {
          this.historicoPropostasCoordenadorDepartamento = response.data;
        });
      }
       if(this.$store.state.user.roleDB == 'proponente_curso'){
        axios.get("/api/coordenadorCurso/propostasPendentes").then(response => {
        this.propostasPendentesCoordenadorCurso = response.data;
      });
      axios.get("/api/coordenadorCurso/historicoPropostas").then(response => {
        this.historicoPropostasCoordenadorCurso = response.data;
      });
       }
    },
  },
  computed: {
    user() {
      return this.$store.state.user;
    }
  },
  mounted() {
    if (this.$store.state.user.roleDB == "proponente_departamento") {
      this.isActiveProponente = true;
      axios
        .get("/api/coordenadorDepartamento/propostasPendentes")
        .then(response => {
          this.propostasPendentesCoordenadorDepartamento = response.data;
        });
      axios
        .get("/api/coordenadorDepartamento/historicoPropostas")
        .then(response => {
          this.historicoPropostasCoordenadorDepartamento = response.data;
        });
    } else if (this.$store.state.user.roleDB == "proponente_curso") {
      this.isActiveProponente = true;
      axios.get("/api/coordenadorCurso/propostasPendentes").then(response => {
        this.propostasPendentesCoordenadorCurso = response.data;
      });
      axios.get("/api/coordenadorCurso/historicoPropostas").then(response => {
        this.historicoPropostasCoordenadorCurso = response.data;
      });
    } else if (this.$store.state.user.roleDB == "diretor_uo") {
      this.isActiveDiretorUO = true;
    } else if (this.$store.state.user.roleDB == "ctc") {
      this.isActiveCTC = true;
    } else if (this.$store.state.user.roleDB == "secretariado_direcao") {
      this.isActiveSD = true;
    } else if (this.$store.state.user.roleDB == "recursos_humanos") {
      this.isActiveRH = true;
    }
  }
};
</script>

<style lang="scss">
//* NAVBAR
.navbar-brand {
  font-size: 30px;
  font-weight: 300;
}

.navbar-brand img {
  cursor: pointer;
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
  text-align: center;
  height: 20%;
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
