<template>
  <div>
    <div v-if="this.$store.state.user.roleDB == 'ctc' && mostrarCTCComponent">
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
                  v-for="(propostaPendenteCTC, index) in propostasPendentesCTC"
                  :key="propostaPendenteCTC.id"
                >
                  <td>{{ propostaPendenteCTC.nome_completo }}</td>
                  <td>{{ propostaPendenteCTC.tipo_contrato }}</td>
                  <td>{{ propostaPendenteCTC.curso }}</td>
                  <td>{{ propostaPendenteCTC.unidade_organica }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="verDetalhes(propostaPendenteCTC, index)"
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
                  v-for="(propostaHistorico, index) in historicoPropostasCTC"
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
    <resumo-diretor v-if="isResumoChecked"
    v-on:mostrar-ctc="mostrarCTC"
    :propostaSelecionada="propostaSelecionada"></resumo-diretor>
  </div>
</template>
<script>
export default {
  data() {
    return {
      propostasPendentesCTC: [],
      historicoPropostasCTC: [],
      mostrarCTCComponent:true,
      propostaSelecionada:{}, 
      isResumoChecked:false,  
    };
  },
  methods: {
      verDetalhes(propostaPendenteCTC, index){
        this.propostaSelecionada = Object.assign({}, propostaPendenteCTC);
        this.mostrarCTCComponent=false;
        this.isResumoChecked=true;
      },
      mostrarCTC(){
      this.isResumoChecked = false;
      this.mostrarCTCComponent = true;
      }
  },
  mounted() {
    axios.get("/api/ctc/getPropostasPendentesCTC").then(response => {
      this.propostasPendentesCTC = response.data;
    });
    axios.get('/api/ctc/getHistoricoPropostasCTC').then(response => {
       this.historicoPropostasCTC = response.data;
    })
  }
};
</script>