<template>
  <div>
    <h2>Proponente (Professor)</h2>
    <br>
    <h5>Qual será a categoria específica do professor a ser contratado?</h5>
    <br>
    <div id="radio_role_professor" class="radio">
      <input
        name="Role"
        v-validate="'required'"
        type="radio"
        v-model="propostaProponenteProfessor.role_professor"
        value="Coordenador"
      > Coordenador
      <br>
      <input
        name="Role"
        type="radio"
        v-model="propostaProponenteProfessor.role_professor"
        value="Adjunto"
      > Adjunto
      <br>
      <input
        name="Role"
        type="radio"
        v-model="propostaProponenteProfessor.role_professor"
        value="Visitante"
      > Visitante
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Role')"
    >{{ errors.first('Role') }}</div>
    <br>
    <div>
      <h5>Regime de prestação de serviços:</h5>
      <br>
      <div id="radio_regime" class="radio">
        <input
          name="Regime Prestação Serviços"
          v-validate="'required'"
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Tempo Integral"
        > Tempo Integral
        <br>
        <input
          name="Regime Prestação Serviços"
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Tempo Parcial"
        > Tempo Parcial
        <br>
        <input
          name="Regime Prestação Serviços"
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Dedicação Exclusiva"
        > Dedicação Exclusiva
        <br>
      </div>
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Regime Prestação Serviços')"
      >{{ errors.first('Regime Prestação Serviços') }}</div>
    </div>
    <br>
    <span v-if="propostaProponenteProfessor.regime_prestacao_servicos == 'Tempo Parcial'">
      <h5>Percentagem de tempo parcial:</h5>
      <br>
      <input
        name="Percentagem Prestação Serviços"
        v-validate="'nullable|min_value:1|max_value:100'"
        type="number"
        class="form-control"
        placeholder="Insira um valor entre 1 e 100"
        v-model="propostaProponenteProfessor.percentagem_prestacao_servicos"
      >
      <div
        class="help-block alert alert-danger"
        v-show="errors.has('Percentagem Prestação Serviços')"
      >{{ errors.first('Percentagem Prestação Serviços') }}</div>
    </span>
    <br>
    <div>
      <h5>Duração do contrato</h5>
      <br>
      <input
        type="text"
        class="form-control"
        v-model="propostaProponenteProfessor.duracao"
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
        type="text"
        class="form-control"
        v-model="propostaProponenteProfessor.periodo"
        name="Periodo"
        v-validate="'required'"
      >
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Periodo')"
    >{{ errors.first('Periodo') }}</div>
    <br>
    
    <button type="button" class="btn btn-success" v-on:click="continuar">Continuar</button>
    <br>
    <resumo-proposta
      v-if="avancar"
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :propostaProponenteProfessor="propostaProponenteProfessor"
    ></resumo-proposta>
  </div>
</template>
<script>
module.exports = {
  props: ["proposta", "unidadesCurriculares"],
  data() {
    return {
      propostaProponenteProfessor: {
        role_professor: "",
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        duracao: "",
        periodo: "",
        proposta_proponente_id: ""
      },
      dataFimContratoText: "",
      avancar: false
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