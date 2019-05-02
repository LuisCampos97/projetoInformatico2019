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
        name="Regime Prestação Serviços"
        v-validate="'required'"
      > Tempo Integral
      <br>
      <input
        type="radio"
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        value="Tempo Parcial"
        name="Regime Prestação Serviços"
      > Tempo Parcial
      <br>
      <input
        type="radio"
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        value="Dedicação Exclusiva"
        name="Regime Prestação Serviços"
      > Dedicação Exclusiva
      <br>
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Regime Prestação Serviços')"
    >{{ errors.first('Regime Prestação Serviços') }}</div>
    <br>
    <span v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'Tempo Parcial'">
      <h5>Percentagem de tempo parcial:</h5>
      <br>
      <input
        type="number"
        class="form-control"
        placeholder="Insira um valor entre 1 e 100"
        name="Percentagem Prestação Serviços"
        v-validate="'nullable'"
        v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
      >
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Percentagem Prestação Serviços')"
      >{{ errors.first('Percentagem Prestação Serviços') }}</div>
    </span>
    <br>
    <br>
    <div>
      <h5>Duração do contrato</h5>
      <br>
      <input
        type="text"
        class="form-control"
        v-model="propostaProponenteAssistente.duracao"
        name="Duração Contrato"
        v-validate="'required'"
      >
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Duração Contrato')"
    >{{ errors.first('Duração Contrato') }}</div>
    <br>
    <div>
      <h5>Periodo</h5>
      <br>
      <input
        type="date"
        class="form-control"
        v-model="propostaProponenteAssistente.periodo"
        name="Periodo"
        v-validate="'required'"
      >
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Periodo')"
    >{{ errors.first('Periodo') }}</div>
    <br>
    <button type="button" class="btn btn-success" v-on:click="continuar">Seguinte</button>
    <br>
    <resumo-proposta
      v-if="avancar"
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :propostaProponenteAssistente="propostaProponenteAssistente"
    ></resumo-proposta>
  </div>
</template>
<script>
module.exports = {
  props: ["proposta", "unidadesCurriculares"],
  data() {
    return {
      propostaProponenteAssistente: {
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        duracao: "",
        periodo:"",
        proposta_proponente_id: ""
      },
      dataFimContratoText: "",
      avancar: false,
    };
  },
  methods: {
    continuar() {
      this.$validator.validateAll().then(() => {
        this.avancar = true;
      });
    }
  }
};
</script>