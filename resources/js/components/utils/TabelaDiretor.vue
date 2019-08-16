<template>
  <div class="main">
    <!-- <button class=" btn btn-success mb-4 font-weight-bold" v-on:click.prevent="novaProposta">
      <i class="fas fa-plus"></i> Nova Proposta
    </button>-->
    <div v-if="this.$store.state.user.roleDB == 'diretor_uo' && mostrarDiretorComponent">
      <div class="separator">
        <b-tabs content-class="mt-3" align="left">
          <b-tab title="Propostas Pendentes" active>
            <table class="table">
              <thead>
                <th>Nome docente a ser contratado</th>
                <th>Tipo contrato</th>
                <th>Curso</th>
                <th>Unidade Organica</th>
                <th>Ações</th>
              </thead>
              <tbody>
                <tr
                  v-for="(propostaPendenteDiretor, index) in propostasPendentesDiretorUO"
                  :key="propostaPendenteDiretor.id"
                >
                  <td>{{ propostaPendenteDiretor.nome_completo }}</td>
                  <td>{{ propostaPendenteDiretor.tipo_contrato }}</td>
                  <td>{{ propostaPendenteDiretor.curso }}</td>
                  <td>{{ propostaPendenteDiretor.unidade_organica }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="verDetalhes(propostaPendenteDiretor, index)"
                    >Ver detalhes</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </b-tab>
          <b-tab title="Histórico de Propostas">
            <table class="table ">
              <thead>
                <th>Nome docente a ser contratado</th>
                <th>Tipo contrato</th>
                <th>Curso</th>
                <th>Unidade Organica</th>
                <th>Parecer</th>
                <th>Ações</th>
              </thead>
              <tbody>
                <tr
                  v-for="(propostaHistorico, index) in historicoPropostasDiretorUO"
                  :key="propostaHistorico.id">
                  <td>{{ propostaHistorico.nome_completo }}</td>
                  <td>{{ propostaHistorico.tipo_contrato }}</td>
                  <td>{{ propostaHistorico.curso }}</td>
                  <td>{{ propostaHistorico.unidade_organica }}</td>
                  <td>{{ propostaHistorico.parecer}}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="verDetalhes(propostaHistorico, index)"
                    >Ver detalhes</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </b-tab>
        </b-tabs>
      </div>
    </div>

    <resumo-geral v-if="isResumoChecked"
     v-on:mostrar-diretor="mostrarDiretor" :propostaSelecionada="propostaSelecionada"></resumo-geral>
  </div>
</template>

<script>
export default {
  data() {
    return {
      header: "dark",
      propostasPendentesDiretorUO: [],
      historicoPropostasDiretorUO: [],
      isResumoChecked: false,
      mostrarDiretorComponent: true,
      propostaSelecionada: {}
    };
  },
  methods: {
    getPropostasPendeste() {},
    getHisstoricoPropostas() {
      //? Propostas Aceites e Recusadas
    },
    verDetalhes(propostaPendenteDiretor, index) {
      this.propostaSelecionada = Object.assign({}, propostaPendenteDiretor);
      this.mostrarDiretorComponent = false;
      this.isResumoChecked = true;

    },
    mostrarDiretor(){
      this.isResumoChecked = false;
      this.mostrarDiretorComponent = true;
      axios.get("/api/diretorUO/propostasPendentes").then(response => {
        this.propostasPendentesDiretorUO = response.data;
      });
      axios.get("/api/diretorUO/historicoPropostas").then(response => {
        this.historicoPropostasDiretorUO = response.data;
      });
    }
  },
  mounted() {
    if (this.$store.state.user.roleDB == "diretor_uo") {
      axios.get("/api/diretorUO/propostasPendentes").then(response => {
        this.propostasPendentesDiretorUO = response.data;
      });
      axios.get("/api/diretorUO/historicoPropostas").then(response => {
        this.historicoPropostasDiretorUO = response.data;
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.main {
  font-size: 20px;
  font-family: "Montserrat", sans-serif;
}
</style>
