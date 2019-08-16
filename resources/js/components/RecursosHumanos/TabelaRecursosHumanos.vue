<template>
  <div>
    <div v-if="this.$store.state.user.roleDB == 'recursos_humanos' && mostrarRHComponent">
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
                  v-for="(propostaPendenteRecursosHumanos, index) in propostasPendentesRecursosHumanos"
                  :key="propostaPendenteRecursosHumanos.id"
                >
                  <td>{{ propostaPendenteRecursosHumanos.nome_completo }}</td>
                  <td>{{ propostaPendenteRecursosHumanos.tipo_contrato }}</td>
                  <td>{{ propostaPendenteRecursosHumanos.curso }}</td>
                  <td>{{ propostaPendenteRecursosHumanos.unidade_organica }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="verDetalhes(propostaPendenteRecursosHumanos, index)"
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
                <th>Curso</th>
                <th>Unidade Organica</th>
                <th>Parecer</th>
                <th>Ações</th>
              </thead>
              <tbody>
                <tr
                  v-for="(propostaHistorico, index) in historicoPropostasRecursosHumanos"
                  :key="propostaHistorico.id"
                >
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
    <resumo-geral
      v-if="isResumoChecked"
      v-on:mostrar-recursos="mostrarRecursos"
      :propostaSelecionada="propostaSelecionada"
    ></resumo-geral>
  </div>
</template>
<script>
export default {
  data() {
    return {
      propostasPendentesRecursosHumanos: "",
      historicoPropostasRecursosHumanos: "",
      mostrarRHComponent: true,
      propostaSelecionada: {},
      isResumoChecked: false
    };
  },
  methods: {
    mostrarRecursos() {
      this.isResumoChecked = false;
      this.mostrarRHComponent = true;
      axios
      .get("/api/recursosHumanos/getPropostasPendentesRecursosHumanos")
      .then(response => {
        this.propostasPendentesRecursosHumanos = response.data;
      });
    axios
      .get("/api/recursosHumanos/getHistoricoPropostasRecursosHumanos")
      .then(response => {
        this.historicoPropostasRecursosHumanos = response.data;
      });
    },
    verDetalhes(propostaPendenteRecursosHumanos, index) {
      this.propostaSelecionada = Object.assign(
        {},
        propostaPendenteRecursosHumanos
      );
      this.isResumoChecked = true;
      this.mostrarRHComponent = false;
    }
  },
  mounted() {
    axios
      .get("/api/recursosHumanos/getPropostasPendentesRecursosHumanos")
      .then(response => {
        this.propostasPendentesRecursosHumanos = response.data;
      });
    axios
      .get("/api/recursosHumanos/getHistoricoPropostasRecursosHumanos")
      .then(response => {
        this.historicoPropostasRecursosHumanos = response.data;
      });
  }
};
</script>