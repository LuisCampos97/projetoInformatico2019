<template>
  <div>
    <h2 class="pb-4">Proponente (Assistente)</h2>
    <b-form-group label="Regime de prestação de serviços">
      <b-form-radio-group
        v-model="propostaProponenteAssistente.regime_prestacao_servicos"
        :options="regimePrestacaoServicosArray"
        :state="$v.propostaProponenteAssistente.regime_prestacao_servicos.$dirty ? !$v.propostaProponenteAssistente.regime_prestacao_servicos.$error : null"
        stacked
      ></b-form-radio-group>
      <b-form-invalid-feedback
        id="input-1-live-feedback"
      >A seleção do regime de prestaões de serviço é obrigatória!</b-form-invalid-feedback>
    </b-form-group>
    <span v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'tempo_parcial'">
      <b-form-group
        description="(cfr. acta do CTC - art. 5º, nº3) N.B Contracto e renovações não podem ter duração superior a 4 anos"
      >
        <b-form-checkbox
          v-model="propostaProponenteAssistente.fundamentacao"
          value="true"
          unchecked-value="false"
          description="We'll never share your email with anyone else."
        >Fundamentação</b-form-checkbox>
      </b-form-group>

      <b-form-group label="Percentagem de tempo parcial" label-for="inputTempoParcial" v-if="propostaProponenteAssistente.fundamentacao == 'true'">
        <b-form-select
          id="inputTempoParcial"
          v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
          :state="$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$error : null"
          :options="percentagensArrayFundamentacao"
        ></b-form-select>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group label="Percentagem de tempo parcial" label-for="inputTempoParcial" v-if="propostaProponenteAssistente.fundamentacao == 'false' || propostaProponenteAssistente.fundamentacao == null">
        <b-form-select
          id="inputTempoParcial"
          v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
          :state="$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$dirty ? !$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$error : null"
          :options="percentagensArray"
        ></b-form-select>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
    </span>

    <b-form-group label="Duração do contrato" label-for="inputDuracaoContrato">
      <b-form-input
        id="inputDuracaoContrato"
        :state="$v.propostaProponenteAssistente.duracao.$dirty ? !$v.propostaProponenteAssistente.duracao.$error : null"
        v-model="propostaProponenteAssistente.duracao"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">A duração do contrato é obrigatória!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Periodo" label-for="inputPeriodo">
      <b-form-input
        id="inputPeriodo"
        :state="$v.propostaProponenteAssistente.periodo.$dirty ? !$v.propostaProponenteAssistente.periodo.$error : null"
        v-model="propostaProponenteAssistente.periodo"
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
    <resumo-proposta
      v-if="avancar"
      :proposta="proposta"
      :unidadesCurriculares="unidadesCurriculares"
      :propostaProponenteAssistente="propostaProponenteAssistente"
    ></resumo-proposta>
  </div>
</template>
<script>
import { required, between } from "vuelidate/lib/validators";

export default {
  props: ["proposta", "unidadesCurriculares"],
  data() {
    return {
      percentagensArray: [
        { text: "55% (7 horas)", value: "55" },
        { text: "50% (6 horas)", value: "50" },
        { text: "40% (5 horas)", value: "40" },
        { text: "30% (4 horas)", value: "30" },
        { text: "20% (3 horas)", value: "20" },
        { text: "15% (2 horas)", value: "15" }
      ],
      percentagensArrayFundamentacao: [
        { text: "80% (10 horas)", value: "80" },
        { text: "70% (9 horas)", value: "70" },
        { text: "60% (8 horas)", value: "60" }
      ],
      categoriaArray: [
        { text: "Coordenador", value: "coordenador" },
        { text: "Adjunto", value: "adjunto" },
        { text: "Visitante", value: "visitante" }
      ],
      regimePrestacaoServicosArray: [
        { text: "Tempo Integral", value: "tempo_integral" },
        { text: "Tempo Parcial", value: "tempo_parcial" },
        { text: "Dedicação Exclusiva", value: "dedicacao_exclusiva" }
      ],
      propostaProponenteAssistente: {
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        duracao: "",
        periodo: "",
        proposta_proponente_id: "",
        fundacao: null
      },
      dataFimContratoText: "",
      avancar: false
    };
  },
  //? Validations Vuelidate
  validations: {
    propostaProponenteAssistente: {
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