<template>
  <div>
    <div v-show="isShowMonitor">
    <h2 class="pb-4">Monitor</h2>
    <h5>Tempo Parcial</h5>
    <b-form-group label="Ciclo do docente a ser contratado">
      <b-form-radio-group
        v-model="propostaProponenteMonitor.ciclo"
        :options="ciclosArray"
        :state="$v.propostaProponenteMonitor.ciclo.$dirty ? !$v.propostaProponenteMonitor.ciclo.$error : null"
      ></b-form-radio-group>
      <b-form-invalid-feedback id="input-1-live-feedback">A seleção de um ciclo é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
      label="Percentagem de tempo parcial"
      label-for="inputTempoParcial"
      v-if="propostaProponenteMonitor.ciclo == '1ciclo'"
    >
      <b-form-select
        id="inputTempoParcial"
        v-model="propostaProponenteMonitor.percentagem_prestacao_servicos"
        :state="$v.propostaProponenteMonitor.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteMonitor.percentagem_prestacao_servicos.$error : null"
        :options="percentagensArray1Ciclo"
      ></b-form-select>
      <b-form-invalid-feedback
        id="input-1-live-feedback"
      >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group
      label="Percentagem de tempo parcial"
      label-for="inputTempoParcial"
      v-if="propostaProponenteMonitor.ciclo == '2ciclo'"
    >
      <b-form-select
        id="inputTempoParcial"
        v-model="propostaProponenteMonitor.percentagem_prestacao_servicos"
        :state="$v.propostaProponenteMonitor.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteMonitor.percentagem_prestacao_servicos.$error : null"
        :options="percentagensArray2Ciclo"
      ></b-form-select>
      <b-form-invalid-feedback
        id="input-1-live-feedback"
      >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Duração do contrato" label-for="inputDuracaoContrato">
      <b-form-input
        id="inputDuracaoContrato"
        :state="$v.propostaProponenteMonitor.duracao.$dirty ? !$v.propostaProponenteMonitor.duracao.$error : null"
        v-model="propostaProponenteMonitor.duracao"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">A duração do contrato é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Periodo" label-for="inputPeriodo">
      <b-form-input
        id="inputPeriodo"
        :state="$v.propostaProponenteMonitor.periodo.$dirty ? !$v.propostaProponenteMonitor.periodo.$error : null"
        v-model="propostaProponenteMonitor.periodo"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">O periodo do contrato é obrigatório!</b-form-invalid-feedback>
    </b-form-group>

    <button class="btn btn-info mt-3 font-weight-bold" v-on:click.prevent="anterior">
      <i class="fas fa-arrow-left"></i> Anterior
    </button>

    <button class="btn btn-success mt-3 font-weight-bold" v-on:click.prevent="seguinte">
      Seguinte
      <i class="fas fa-arrow-right"></i>
    </button>
    </div>
    <resumo-proposta
      v-if="avancar"
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :propostaProponenteMonitor="propostaProponenteMonitor"
      :ficheiro="ficheiro"
    ></resumo-proposta>
  </div>
</template>
<script>
import { required, between } from "vuelidate/lib/validators";

export default {
  props: ["proposta", "unidadesCurriculares", "ficheiro"],
  data() {
    return {
      ciclosArray: [
        { text: "1º Ciclo", value: "1ciclo" },
        { text: "2º Ciclo", value: "2ciclo" }
      ],
      percentagensArray1Ciclo: [
        { text: "40% (5 horas)", value: "40" },
        { text: "30% (4 horas)", value: "30" },
        { text: "20% (3 horas)", value: "20" },
        { text: "15% (2 horas)", value: "15" }
      ],
      percentagensArray2Ciclo: [
        { text: "60% (8 horas)", value: "60" },
        { text: "55% (7 horas)", value: "55" },
        { text: "50% (6 horas)", value: "50" },
        { text: "40% (5 horas)", value: "40" },
        { text: "30% (4 horas)", value: "30" },
        { text: "20% (3 horas)", value: "20" },
        { text: "15% (2 horas)", value: "15" }
      ],
      categoriaArray: [
        { text: "Coordenador", value: "coordenador" },
        { text: "Adjunto", value: "adjunto" },
        { text: "Visitante", value: "visitante" }
      ],
      propostaProponenteMonitor: {
        regime_prestacao_servicos: "Tempo Parcial",
        percentagem_prestacao_servicos: "",
        duracao: "",
        periodo: "",
        proposta_proponente_id: "",
        ciclo: ""
      },
      dataFimContratoText: "",
      avancar: false,
      isShowMonitor: true
    };
  },
  //? Validations Vuelidate
  validations: {
    propostaProponenteMonitor: {
      percentagem_prestacao_servicos: { between: between(1, 100) },
      duracao: { required },
      periodo: { required },
      ciclo: { required }
    }
  },
  methods: {
    seguinte() {
      //* Mudar para o componente Resumo Proposta
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.avancar = true;
        this.isShowMonitor = false;
        this.$emit("incrementarBarraProgresso");
      }
    },
    anterior() {
      //* Mudar para o componente Proponente
      this.$emit("mostrarProponente");
    }
  }
};
</script>