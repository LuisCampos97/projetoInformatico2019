<template>
  <div>
    <h2>Proponente (Professor)</h2>
    <br>
    <h5>Qual será o role específico do professor a ser contratado?</h5>
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
      <h5>Duração do contrato (em meses)</h5>
      <br>
      <input
        type="text"
        class="form-control"
        placeholder="Insira um valor positivo e inteiro"
        v-model="propostaProponenteProfessor.duracao"
        name="Duração Contrato"
        v-validate="'required|min_value:1'"
      >
    </div>
    <div
      class="help-block alert alert-danger"
      v-show="errors.has('Duração Contrato')"
    >{{ errors.first('Duração Contrato') }}</div>
    <br>
    <div>
      <h5>Data de inicio do contrato</h5>
      <br>
      <input
        type="date"
        class="form-control"
        placeholder="Selecione a data de inicio de contrato"
        v-model="propostaProponenteProfessor.data_inicio_contrato"
        name="Data Inicio Contrato"
        v-validate="'required'"
        @change="setDataFimContrato(propostaProponenteProfessor.duracao)"
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
        data_inicio_contrato: "",
        data_fim_contrato: "",
        proposta_proponente_id: ""
      },
      dataFimContratoText: "",
      avancar: false
    };
  },
  methods: {
    setDataFimContrato(duracao) {
      var array = this.propostaProponenteProfessor.data_inicio_contrato.split(
        "-"
      );
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
      this.propostaProponenteProfessor.data_fim_contrato = new Date(data)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
    },
    continuar() {
      this.$validator.validateAll().then(() => {});
      this.avancar = true;
    }
  }
};
</script>