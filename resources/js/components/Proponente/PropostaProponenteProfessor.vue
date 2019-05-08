<template>
  <div>
    <h2 class="pb-4">Proponente (Professor)</h2>
    <b-form-group label="Categoria específica do professor a ser contratado">
      <b-form-radio-group
        v-model="propostaProponenteProfessor.role_professor"
        :options="categoriaArray"
        :state="$v.propostaProponenteProfessor.role_professor.$dirty ? !$v.propostaProponenteProfessor.role_professor.$error : null"
        stacked
      ></b-form-radio-group>
      <b-form-invalid-feedback id="input-1-live-feedback">A seleção de uma categoria é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Regime de prestação de serviços">
      <b-form-radio-group
        v-model="propostaProponenteProfessor.regime_prestacao_servicos"
        :options="regimePrestacaoServicosArray"
        :state="$v.propostaProponenteProfessor.regime_prestacao_servicos.$dirty ? !$v.propostaProponenteProfessor.regime_prestacao_servicos.$error : null"
        stacked
      ></b-form-radio-group>
      <b-form-invalid-feedback
        id="input-1-live-feedback"
      >A seleção do regime de prestaões de serviço é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <span v-if="propostaProponenteProfessor.regime_prestacao_servicos == 'tempo_parcial'">
      <b-form-group label="Percentagem de tempo parcial" label-for="inputPercentagemTempoParcial">
        <b-form-input
          id="inputPercentagemTempoParcial"
          type="number"
          :state="$v.propostaProponenteProfessor.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteProfessor.percentagem_prestacao_servicos.$error : null"
          v-model="propostaProponenteProfessor.percentagem_prestacao_servicos"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">A percentagem deve estar entre 1 e 100%</b-form-invalid-feedback>
      </b-form-group>
    </span>

    <b-form-group label="Duração do contrato" label-for="inputDuracaoContrato">
      <b-form-input
        id="inputDuracaoContrato"
        :state="$v.propostaProponenteProfessor.duracao.$dirty ? !$v.propostaProponenteProfessor.duracao.$error : null"
        v-model="propostaProponenteProfessor.duracao"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">A duração do contrato é obrigatória!</b-form-invalid-feedback>
    </b-form-group>
    
    <b-form-group label="Periodo" label-for="inputPeriodo">
      <b-form-input
        id="inputPeriodo"
        :state="$v.propostaProponenteProfessor.periodo.$dirty ? !$v.propostaProponenteProfessor.periodo.$error : null"
        v-model="propostaProponenteProfessor.periodo"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">O periodo do contrato é obrigatório!</b-form-invalid-feedback>
    </b-form-group>

    <button
        class="btn btn-info mt-3 font-weight-bold"
        v-on:click.prevent="anterior"
      >
        <i class="fas fa-arrow-left"></i> Anterior
      </button>

    <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="seguinte"
      >
        Seguinte
        <i class="fas fa-arrow-right"></i>
      </button>
    <resumo-proposta
      v-if="avancar"
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :propostaProponenteProfessor="propostaProponenteProfessor"
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
      categoriaArray: [
        { text: "Coordenador", value: "Coordenador" },
        { text: "Adjunto", value: "Adjunto" },
        { text: "Visitante", value: "Visitante" }
      ],
      regimePrestacaoServicosArray: [
        { text: "Tempo Integral", value: "Tempo Integral" },
        { text: "Tempo Parcial", value: "Tempo Parcial" },
        { text: "Dedicação Exclusiva", value: "Dedicacao Exclusiva" }
      ],
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
  //? Validations Vuelidate
  validations: {
    propostaProponenteProfessor: {
      role_professor: { required },
      regime_prestacao_servicos: { required },
      percentagem_prestacao_servicos: { between: between(1, 100) },
      duracao: { required },
      periodo: { required }
    }
  },
  methods: {
    seguinte() {
      //* Mudar para o componente Resumo Proposta
      this.$v.$touch();
      if (!this.$v.$invalid) {
        this.avancar = true;
      }
    },
    anterior() {
      //* Mudar para o componente Proponente
    }
  }
};
</script>