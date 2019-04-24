<template>
  <div>
    <h2>Proponente (Assistente)</h2>
    <br>
    <h5>Regime de prestação de serviços:</h5>
    <br>
    <div id="radio_regime" class="radio">
      <input
        type="radio"
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        value="Tempo Integral"
      > Tempo Integral
      <br>
      <input
        type="radio"
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        value="Tempo Parcial"
      > Tempo Parcial
      <br>
      <input
        type="radio"
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        value="Dedicação Exclusiva"
      > Dedicação Exclusiva
      <br>
    </div>
    <br>
    <span v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'Tempo Parcial'">
      <h5>Percentagem de tempo parcial:</h5>
      <br>
      <input
        type="number"
        class="form-control"
        placeholder="Insira um valor entre 1 e 100"
        v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
      >
    </span>
    <br>
    <br>
    <div>
      <h5>Duração do contrato (em meses)</h5>
      <br>
      <input
        type="text"
        class="form-control"
        placeholder="Insira um valor positivo e inteiro"
        v-model="propostaProponenteAssistente.duracao"
      >
    </div>
    <br>
    <div>
      <h5>Data de inicio do contrato</h5>
      <br>
      <input
        type="date"
        class="form-control"
        placeholder="Selecione a data de inicio de contrato"
        v-model="propostaProponenteAssistente.data_inicio_contrato"
        @change="setDataFimContrato(propostaProponenteAssistente.duracao)"
      >
    </div>
    <br>
    <div>
      <h5>Data de fim do contrato</h5>
      <br>
      <input type="text" class="form-control" v-model="dataFimContratoText" readonly>
      <br>
    </div>

    <button
      type="button"
      class="btn btn-success"
      v-on:click="criarPropostaProponenteAssistente(propostaProponenteAssistente)"
    >Finalizar e criar proposta</button>
  </div>
</template>
<script>
module.exports = {
  props: ["idParaUcsPropostaProponente"],
  data() {
    return {
      propostaProponenteAssistente: {
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        duracao: "",
        data_inicio_contrato: "",
        data_fim_contrato: "",
        proposta_proponente_id: ""
      },
      dataFimContratoText: ""
    };
  },
  methods: {
    setDataFimContrato(duracao) {
      this.propostaProponenteAssistente.proposta_proponente_id = this.idParaUcsPropostaProponente;
      var array = this.propostaProponenteAssistente.data_inicio_contrato.split(
        "-"
      );
      console.log(array[2], array[1], array[0]);
      let data = new Date(
        parseInt(array[0]),
        parseInt(array[1]) - 1,
        parseInt(array[2])
      );
      data.setMonth(data.getUTCMonth() + parseInt(duracao));
      let dia = data.getDate();
      let mes = data.getMonth() + 1;
      let ano = data.getFullYear();
      this.dataFimContratoText = dia + "/" + mes + "/" + ano;
      this.propostaProponenteAssistente.data_fim_contrato = new Date(data)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
      console.log(this.propostaProponenteAssistente.data_fim_contrato);
    },
    criarPropostaProponenteAssistente(propostaProponenteAssistente) {
      if (
        this.propostaProponenteAssistente.regime_prestacao_servicos == "" ||
        this.propostaProponenteAssistente.duracao == "" ||
        this.propostaProponenteAssistente.data_inicio_contrato == "" ||
        this.propostaProponenteAssistente.data_fim_contrato == ""||
        this.propostaProponenteAssistente.proposta_proponente_id == ""
      ) {
        console.log("ERROR!!! Validar ainda nas caixas correspondentes");
      } else {
        axios
          .post(
            "/api/propostaProponenteAssistente",
            propostaProponenteAssistente
          )
          .then(response => {});
      }
    }
  }
};
</script>