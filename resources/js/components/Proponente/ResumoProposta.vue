<template>
  <div>
    <h2>
      <strong>Resumo da Proposta de contratação</strong>
    </h2>
    <br>
    <h4>
      <strong>Informações gerais</strong>
    </h4>
    <div class="jumbotron">
      <br>
      <h5>
        <strong>Tipo de contratação:</strong>
        {{ proposta.tipo_contrato }}
      </h5>
      <br>
      <h5>
        <strong>Unidade Organica:</strong>
        {{ proposta.unidade_organica }}
      </h5>
      <br>
      <h5>
        <strong>Nome completo:</strong>
        {{ proposta.nome_completo }}
      </h5>
      <br>
      <h5>
        <strong>Papel do docente:</strong>
        {{ proposta.role }}
      </h5>
    </div>
    <br>
    <h4>
      <strong>Unidades Curriculares</strong>
    </h4>
    <div>
      <table class="table">
        <thead>
          <th>Nome</th>
          <th>Regime</th>
          <th>Turno</th>
          <th>Horas</th>
          <th>Horas Semestrais</th>
          <th>Tipo</th>
        </thead>
        <tbody>
          <tr v-for="(ucAUX) in unidadesCurriculares" :key="ucAUX.id">
            <td>{{ucAUX.nome_unidade_curricular}}</td>
            <td>{{ucAUX.regime}}</td>
            <td>{{ucAUX.turno}}</td>
            <td>{{ucAUX.horas}}</td>
            <td>{{ucAUX.horas_semestrais}}</td>
            <td>{{ucAUX.tipo}}</td>
          </tr>
        </tbody>
      </table>
      <br>
    </div>
    <br>
    <h4>
      <strong>Informações Especificas</strong>
    </h4>
    <br>
    <div class="jumbotron">
      <div v-if="proposta.role=='professor'">
        <h5>
          <strong>Tipo de professor:</strong>
          {{ propostaProponenteProfessor.role_professor }}
        </h5>
      </div>
      <br>
      <h5>
        <strong>Regime de prestação de serviços:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.regime_prestacao_servicos }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.regime_prestacao_servicos }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.regime_prestacao_servicos }}</h5>
      </div>
      <br>

      <div v-if="propostaProponenteProfessor">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteProfessor.percentagem_prestacao_servicos }}
      </div>

      <div v-if="propostaProponenteMonitor">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteMonitor.percentagem_prestacao_servicos }}
      </div>

      <div v-if="propostaProponenteAssistente">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteAssistente.percentagem_prestacao_servicos }}
      </div>
      <h5>
        <strong>Duração do contrato:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.duracao }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.duracao }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.duracao }}</h5>
      </div>
      <br>
      <h5>
        <strong>Periodo:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.periodo }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.periodo }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.periodo }}</h5>
      </div>
      <br>
    </div>

    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaProfessor(propostaProponenteProfessor)"
      @click="makeToast('success')"
      v-if="proposta.role=='professor'"
    >Finalizar</button>
    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaAssistente(propostaProponenteAssistente)"
      v-if="proposta.role=='assistente'"
    >Finalizar</button>
    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaMonitor(propostaProponenteMonitor)"
      v-if="proposta.role=='monitor'"
    >Finalizar</button>
  </div>
</template>
<script src="/socket.io/socket.io.js"></script>
<script>
module.exports = {
  props: [
    "proposta",
    "unidadesCurriculares",
    "propostaProponenteProfessor",
    "propostaProponenteAssistente",
    "propostaProponenteMonitor",
    "ficheiro"
  ],
  data() {
    return {
      idParaUcsPropostaProponente: ""
    };
  },
  methods: {
    submeterPropostaProfessor(propostaProponenteProfessor) {
      let confirmacao = confirm(
        "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
      );
      if (confirmacao) {
        if (this.unidadesCurriculares.length > 0) {
          console.log("Ficheiro");
          console.log(this.ficheiro);
          axios
            .post("/api/propostaProponente/", this.proposta)
            .then(response => {
              this.idParaUcsPropostaProponente = response.data.id;
              this.unidadesCurriculares.forEach(unidadeCurricular => {
                unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
              });
              this.unidadesCurriculares.forEach(unidadeCurricular => {
                axios
                  .post("/api/ucsPropostaProponente/", unidadeCurricular)
                  .then(response => {});
                this.propostaProponenteProfessor.proposta_proponente_id = this.idParaUcsPropostaProponente;

                axios
                  .post(
                    "/api/propostaProponenteProfessor",
                    this.propostaProponenteProfessor
                  )
                  .then(response => {});
              });

              axios
                .post("/api/proposta/" + this.idParaUcsPropostaProponente)
                .then(response => {
                  //var socket = io("http://localhost:8080"); // connec to server
                  this.ficheiro.fileCurriculo.proposta_id = response.data;
                  this.ficheiro.fileHabilitacoes.proposta_id = response.data;
                  this.ficheiro.fileRelatorio.proposta_id = response.data;

                  this.$socket.emit("email-diretor", {
                    msg: "Pedido de email enviado..."
                  }); // raise an event on the server

                  axios
                    .post("/api/ficheiro", this.ficheiro.fileRelatorio)
                    .then(response => {});

                  axios
                    .post("/api/ficheiro", this.ficheiro.fileCurriculo)
                    .then(response => {});
                  axios
                    .post("/api/ficheiro", this.ficheiro.fileHabilitacoes)
                    .then(response => {});
                });
            });
        }
      }
    },
    submeterPropostaAssistente(propostaProponenteAssistente) {
      if (this.unidadesCurriculares.length > 0) {
        axios.post("/api/propostaProponente/", this.proposta).then(response => {
          this.idParaUcsPropostaProponente = response.data.id;
          this.unidadesCurriculares.forEach(unidadeCurricular => {
            unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileCurriculo.proposta_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileHabilitacoes.proposta_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileRelatorio.proposta_id = this.idParaUcsPropostaProponente;
          });
          this.unidadesCurriculares.forEach(unidadeCurricular => {
            axios
              .post("/api/ucsPropostaProponente/", unidadeCurricular)
              .then(response => {});
            this.propostaProponenteAssistente.proposta_proponente_id = this.idParaUcsPropostaProponente;

            axios
              .post(
                "/api/propostaProponenteAssistente",
                propostaProponenteAssistente
              )
              .then(response => {});
          });

          axios
            .post("/api/proposta/" + this.idParaUcsPropostaProponente)
            .then(response => {});
        });

        axios
          .post("/api/ficheiro", this.ficheiro.fileRelatorio)
          .then(response => {});

        axios
          .post("/api/ficheiro", this.ficheiro.fileCurriculo)
          .then(response => {});
        axios
          .post("/api/ficheiro", this.ficheiro.fileHabilitacoes)
          .then(response => {});
      }
    },
    submeterPropostaMonitor(propostaProponenteMonitor) {
      if (this.unidadesCurriculares.length > 0) {
        axios.post("/api/propostaProponente/", this.proposta).then(response => {
          this.idParaUcsPropostaProponente = response.data.id;
          this.unidadesCurriculares.forEach(unidadeCurricular => {
            unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileCurriculo.proposta_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileHabilitacoes.proposta_id = this.idParaUcsPropostaProponente;
            this.ficheiro.fileRelatorio.proposta_id = this.idParaUcsPropostaProponente;
          });
          this.unidadesCurriculares.forEach(unidadeCurricular => {
            axios
              .post("/api/ucsPropostaProponente/", unidadeCurricular)
              .then(response => {});
            this.propostaProponenteMonitor.proposta_proponente_id = this.idParaUcsPropostaProponente;

            axios
              .post("/api/propostaProponenteMonitor", propostaProponenteMonitor)
              .then(response => {});
          });
          axios
            .post("/api/proposta/" + this.idParaUcsPropostaProponente)
            .then(response => {});
          axios
            .post("/api/ficheiro", this.ficheiro.fileRelatorio)
            .then(response => {});

          axios
            .post("/api/ficheiro", this.ficheiro.fileCurriculo)
            .then(response => {});
          axios
            .post("/api/ficheiro", this.ficheiro.fileHabilitacoes)
            .then(response => {});
        });
      }
    },
    makeToast(variant = null) {
      this.$bvToast.toast("O Direretor ", {
        title: `O Diretor da ${
          this.proposta.unidade_organica
        } foi notificado via email!`,
        variant: variant,
        solid: true
      });
    }
  }
};
</script>