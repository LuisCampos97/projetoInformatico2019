<template>
  <div>
    <div
      v-if="this.$store.state.user.roleDB == 'secretariado_direcao' && mostrarSecretariadoComponent"
    >
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
                  v-for="(propostaPendenteSecretariadoDirecao, index) in propostasPendentesSecretariadoDirecao"
                  :key="propostaPendenteSecretariadoDirecao.id"
                >
                  <td>{{ propostaPendenteSecretariadoDirecao.nome_completo }}</td>
                  <td>{{ propostaPendenteSecretariadoDirecao.tipo_contrato }}</td>
                  <td>{{ propostaPendenteSecretariadoDirecao.curso }}</td>
                  <td>{{ propostaPendenteSecretariadoDirecao.unidade_organica }}</td>
                  <td>
                    <button
                      type="button"
                      class="btn btn-info"
                      @click="verDetalhes(propostaPendenteSecretariadoDirecao, index)"
                    >Ver detalhes</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </b-tab>
          <b-tab title="Histórico de Propostas"></b-tab>
        </b-tabs>
      </div>
    </div>
    <resumo-geral v-if="isResumoChecked"
    v-on:mostrar-secretariado="mostrarSecretariado"
    :propostaSelecionada="propostaSelecionada"></resumo-geral>
  </div>
</template>
<script>
export default {
  data() {
    return {
      propostasPendentesSecretariadoDirecao: [],
      historicoPropostasSecretariadoDirecao: [],
      mostrarSecretariadoComponent: true,
      isResumoChecked:false,
      propostaSelecionada:{},
    };
  },
  methods: {
      verDetalhes(propostaPendenteSecretariadoDirecao, index){
          this.propostaSelecionada = Object.assign({}, propostaPendenteSecretariadoDirecao);
          this.isResumoChecked = true;
          this.mostrarSecretariadoComponent = false;
      },
      mostrarSecretariado(){
          this.isResumoChecked=false;
          this.mostrarSecretariadoComponent = true;
      }
  },
  mounted() {
    axios
      .get("/api/secretariadoDirecao/getPropostasPendentesSecretariadoDirecao")
      .then(response => {
        this.propostasPendentesSecretariadoDirecao = response.data;
      });
    axios.get('/api/secretariadoDirecao/getHistoricoPropostasSecretariadoDirecao').then(response => {
        console.log(response);
    })
  }
};
</script>