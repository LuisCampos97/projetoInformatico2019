<template>
  <div>
    <div v-show="isShowAssistente">
      <h2 class="pb-4">Assistente</h2>
      <b-form-group label="Regime de prestação de serviços">
        <b-form-radio-group
          v-model="propostaProponenteAssistente.regime_prestacao_servicos"
          :options="regimePrestacaoServicosArray"
          :state="!$v.propostaProponenteAssistente.regime_prestacao_servicos.$error && null"
          stacked
        ></b-form-radio-group>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A seleção do regime de prestaões de serviço é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group
        label="Percentagem de tempo parcial"
        label-for="inputTempoParcial"
        v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'tempo_parcial_60'"
      >
        <b-form-select
          id="inputTempoParcial"
          v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
          :state="!$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$error && null"
          :options="percentagensArraySuperiorA60"
        ></b-form-select>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group
        label="Percentagem de tempo parcial"
        label-for="inputTempoParcial"
        v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'tempo_parcial'"
      >
        <b-form-select
          id="inputTempoParcial"
          v-model="propostaProponenteAssistente.percentagem_prestacao_servicos"
          :state="!$v.propostaProponenteAssistente.percentagem_prestacao_servicos.$error && null"
          :options="percentagensArray"
        ></b-form-select>
        <b-form-invalid-feedback
          id="input-1-live-feedback"
        >A percentagem de tempo parcial é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
      <b-form-group
        label="Fundamentação"
        description="(cfr. acta do CTC - art. 5º, nº3) N.B Contracto e renovações não podem ter duração superior a 4 anos"
        v-if="propostaProponenteAssistente.regime_prestacao_servicos == 'tempo_integral' ||
        propostaProponenteAssistente.regime_prestacao_servicos == 'tempo_parcial_60' ||
        propostaProponenteAssistente.regime_prestacao_servicos == 'dedicacao_exclusiva'"
      >
        <b-form-textarea
          v-model="propostaProponenteAssistente.fundamentacao"
          :state="!$v.propostaProponenteAssistente.fundamentacao.$error && null"
        ></b-form-textarea>
        <b-form-invalid-feedback id="input-1-live-feedback">A fundamentação é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Duração do contrato" label-for="inputDuracaoContrato">
        <b-form-input
          id="inputDuracaoContrato"
          :state="!$v.propostaProponenteAssistente.duracao.$error && null"
          v-model="propostaProponenteAssistente.duracao"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">A duração do contrato é obrigatória!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Periodo" label-for="inputPeriodo">
        <b-form-input
          id="inputPeriodo"
          :state="!$v.propostaProponenteAssistente.periodo.$error && null"
          v-model="propostaProponenteAssistente.periodo"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">O periodo do contrato é obrigatório!</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group
        label="Avaliação período anterior"
        label-for="inputAvaliacao"
        v-if="proposta.tipo_contrato == 'renovacao' || proposta.tipo_contrato == 'alteracao'">
        <b-form-select
          id="inputAvaliacao"
          v-model="propostaProponenteAssistente.avaliacao_periodo_anterior"
          :options="avaliacao_periodo_anterior_array"
        ></b-form-select>
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
      :propostaProponenteAssistente="propostaProponenteAssistente"
      :ficheiro="ficheiro"
      v-on:mostrarPropostaProponente_assistente="mostrarComponente"
    ></resumo-proposta>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  props: ["proposta", "unidadesCurriculares", "ficheiro"],
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
      percentagensArraySuperiorA60: [
        { text: "80% (10 horas)", value: "80" },
        { text: "70% (9 horas)", value: "70" },
        { text: "60% (8 horas)", value: "60" }
      ],
      regimePrestacaoServicosArray: [
        { text: "Tempo Parcial", value: "tempo_parcial" },
        {
          text: "Tempo Parcial igual ou superior a 60% ",
          value: "tempo_parcial_60"
        },
        { text: "Tempo Integral", value: "tempo_integral" },
        { text: "Dedicação Exclusiva", value: "dedicacao_exclusiva" }
      ],
      avaliacao_periodo_anterior_array: [
        { text: "Positiva", value: "positiva"},
        { text: "Negativa", value: "negativa"},
      ],
      propostaProponenteAssistente: {
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        fundamentacao: "",
        duracao: "",
        periodo: "",
        avaliacao_periodo_anterior:"",
        proposta_proponente_id: ""
      },
      avancar: false,
      isShowAssistente: true
    };
  },
  //? Validations Vuelidate
  validations() {
    /*
    if(this.proposta.tipo_contrato == 'renovacao' || this.proposta.tipo_contrato == 'alteracao'){
      return{
        propostaProponenteAssistente: {
          avaliacao_periodo_anterior: { required },
        }
      };
    }
    */
    if (
      this.propostaProponenteAssistente.regime_prestacao_servicos ==
        "tempo_integral" ||
      this.propostaProponenteAssistente.regime_prestacao_servicos ==
        "dedicacao_exclusiva"
    ) {
      return {
        propostaProponenteAssistente: {
          regime_prestacao_servicos: { required },
          fundamentacao: { required },
          duracao: { required },
          periodo: { required },
        }
      };
    } else {
      if (
        this.propostaProponenteAssistente.regime_prestacao_servicos ==
        "tempo_parcial_60"
      ) {
        return {
          propostaProponenteAssistente: {
            regime_prestacao_servicos: { required },
            fundamentacao: { required },
            percentagem_prestacao_servicos: { required },
            duracao: { required },
            periodo: { required },
          }
        };
      } else {
        return {
          propostaProponenteAssistente: {
            regime_prestacao_servicos: { required },
            percentagem_prestacao_servicos: { required },
            duracao: { required },
            periodo: { required },
          }
        };
      }
    }
  },
  methods: {
    seguinte() {
      //* Mudar para o componente Resumo Proposta
      this.$v.$touch();
      if (!this.$v.$invalid) {
        if (
          this.propostaProponenteAssistente.regime_prestacao_servicos ==
            "Tempo Integral" ||
          this.propostaProponenteAssistente.regime_prestacao_servicos ==
            "Dedicacao Exclusiva"
        ) {
          this.propostaProponenteAssistente.percentagem_prestacao_servicos =
            "100";
        }
        this.avancar = true;
        this.isShowAssistente = false;
        this.$emit("incrementarBarraProgresso");
        this.$store.commit("setPropostaProponenteAssistente", this.propostaProponenteAssistente);
      }
    },
    anterior() {
      //* Mudar para o componente Proponente
      this.$emit("mostrarProponente");
    },
    mostrarComponente() {
      this.isShowAssistente = true;
      this.avancar = false;
      this.$emit("decrementarBarraProgresso");
    }
  },
  mounted() {
    Object.assign(this.propostaProponenteAssistente, this.$store.state.propostaProponenteAssistente);

    //? Se selecionou uma proposta existente
    if (this.proposta.role == "assistente" && this.$store.state.propostaExistente) {
      axios
        .get("/api/propostaProponenteAssistente/" + this.proposta.id)
        .then(response => {
          Object.assign(this.propostaProponenteAssistente, response.data);
        });
    }
  }
};
</script>