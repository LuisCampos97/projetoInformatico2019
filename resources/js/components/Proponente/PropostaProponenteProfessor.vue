<template>
  <div>
    <div v-show="isShowProfessor">
      <h2 class="pb-4">Professor</h2>
      <b-form-group label="Categoria específica do professor a ser contratado">
        <b-form-radio-group
          v-model="propostaProponenteProfessor.role_professor"
          :options="categoriaArray"
          :state="$v.propostaProponenteProfessor.role_professor.$dirty ? !$v.propostaProponenteProfessor.role_professor.$error : null"
          stacked
        ></b-form-radio-group>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A seleção de uma categoria é obrigatória!</b-form-invalid-feedback>
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

      <span v-if="propostaProponenteProfessor.regime_prestacao_servicos == 'Tempo Parcial'">
        <b-form-group label="Percentagem de tempo parcial" label-for="inputTempoParcial">
          <b-form-select
            id="inputTempoParcial"
            v-model="propostaProponenteProfessor.percentagem_prestacao_servicos"
            :state="$v.propostaProponenteProfessor.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteProfessor.percentagem_prestacao_servicos.$error : null"
            :options="percentagensArray"
          ></b-form-select>
          <b-form-invalid-feedback
            id="input-1-live-feedback"
          >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
        </b-form-group>
      </span>

      <b-form-group
        label="Fundamentação"
        description="(cfr. acta do CTC - art. 5º, nº3) N.B Contracto e renovações não podem ter duração superior a 4 anos"
      >
        <b-form-textarea
          v-model="propostaProponenteProfessor.fundamentacao"
          :state="$v.propostaProponenteProfessor.fundamentacao.$dirty ? !$v.propostaProponenteProfessor.fundamentacao.$error : null"
        ></b-form-textarea>
        <b-form-invalid-feedback id="input-1-live-feedback">A fundamentação é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

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
      :propostaProponenteProfessor="propostaProponenteProfessor"
    ></resumo-proposta>
  </div>
</template>
<script>
import { required, between } from "vuelidate/lib/validators";

export default {
  props: ["proposta", "unidadesCurriculares"],
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
      percentagensArray: [
        { text: "80% (10 horas)", value: "80" },
        { text: "70% (9 horas)", value: "70" },
        { text: "60% (8 horas)", value: "60" },
        { text: "55% (7 horas)", value: "55" },
        { text: "50% (6 horas)", value: "50" },
        { text: "40% (5 horas)", value: "40" },
        { text: "30% (4 horas)", value: "30" },
        { text: "20% (3 horas)", value: "20" },
        { text: "15% (2 horas)", value: "15" }
      ],
      propostaProponenteProfessor: {
        role_professor: "",
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        fundamentacao: "",
        duracao: "",
        periodo: "",
        proposta_proponente_id: ""
      },
      dataFimContratoText: "",
      avancar: false,
      isShowProfessor: true
    };
  },
  //? Validations Vuelidate
  validations: {
    propostaProponenteProfessor: {
      role_professor: { required },
      regime_prestacao_servicos: { required },
      percentagem_prestacao_servicos: { between: between(1, 100) },
      fundamentacao: { required },
      duracao: { required },
      periodo: { required }
    }
  },
  methods: {
    seguinte() {
      //* Mudar para o componente Resumo Proposta
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (
          this.propostaProponenteProfessor.regime_prestacao_servicos ==
            "Tempo Integral" ||
          this.propostaProponenteProfessor.regime_prestacao_servicos ==
            "Dedicacao Exclusiva"
        ) {
          this.propostaProponenteProfessor.percentagem_prestacao_servicos =
            "100";
        }
        this.avancar = true;
        this.isShowProfessor = false;
        this.$emit("incrementarBarraProgresso");
      }
    },
    anterior() {
      //* Mudar para o componente Proponente
      this.isShowProfessor = false;
      this.$emit("isShow");
    }
  },
  mounted() {
    this.isShowProfessor = true;
  }
};
</script>