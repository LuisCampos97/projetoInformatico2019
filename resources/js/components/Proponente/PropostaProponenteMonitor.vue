<template>
  <div>
    <h2>Proponente (Monitor)</h2>
    <br>
    <h5>Regime de prestação de serviços:</h5>
    <br>
    <div id="radio_regime" class="radio">
      <input
        type="radio"
        v-model="propostaProponenteMonitor.regime_prestacao_servicos"
        value="Tempo Parcial"
        name="Regime Prestação Serviços"
        v-validate="'required'"
      > Tempo Parcial
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Regime Prestação Serviços')"
      >{{ errors.first('Regime Prestação Serviços') }}</div>
      <br>
      <br>
    </div>
    <br>
    <span v-if="propostaProponenteMonitor.regime_prestacao_servicos == 'Tempo Parcial'">
      <h5>Percentagem de tempo parcial:</h5>
      <br>
      <input
        type="number"
        class="form-control"
        placeholder="Insira um valor entre 1 e 100"
        name="Percentagem Prestação Serviços"
        v-validate="'required|min_value:1|max_value:100'"
        v-model="propostaProponenteMonitor.percentagem_prestacao_servicos"
      >
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Percentagem Prestação Serviços')"
      >{{ errors.first('Percentagem Prestação Serviços') }}</div>
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
        v-model="propostaProponenteMonitor.duracao"
        name="Duração Contrato"
        v-validate="'required|min_value:1'"
      >
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Duração Contrato')"
      >{{ errors.first('Duração Contrato') }}</div>
    </div>
    <br>
    <div>
      <h5>Data de inicio do contrato</h5>
      <br>
      <input
        type="date"
        class="form-control"
        placeholder="Selecione a data de inicio de contrato"
        v-model="propostaProponenteMonitor.data_inicio_contrato"
        name="Data Inicio Contrato"
        v-validate="'required'"
        @change="setDataFimContrato(propostaProponenteMonitor.duracao)"
      >
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Data Inicio Contrato')"
    >{{ errors.first('Data Inicio Contrato') }}</div>
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
      v-on:click="criarpropostaProponenteMonitor(propostaProponenteMonitor)"
    >Finalizar e criar proposta</button>
  </div>
</template>
<script>
module.exports = {
  props: ["idParaUcsPropostaProponente"],
  data() {
    return {
      propostaProponenteMonitor: {
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
      this.propostaProponenteMonitor.proposta_proponente_id = this.idParaUcsPropostaProponente;
      var array = this.propostaProponenteMonitor.data_inicio_contrato.split(
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
      this.propostaProponenteMonitor.data_fim_contrato = new Date(data)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
      console.log(this.propostaProponenteMonitor.data_fim_contrato);
    },
    criarpropostaProponenteMonitor(propostaProponenteMonitor) {
      this.$validator.validateAll().then(() => {
        axios
          .post("/api/propostaProponenteMonitor", propostaProponenteMonitor)
          .then(response => {});
      });
    }
  }
};
</script>