<template>
  <div>
    <div class="jumbotron">
      <h3>Finalização da Proposta (Recursos Humanos)</h3>
      <b-form-group label="Remuneração" label-for="inputRemuneracao">
        <b-form-input
          id="inputRemuneracao"
          :state="$v.propostaRecursosHumanos.remuneracao.$dirty ? !$v.propostaRecursosHumanos.remuneracao.$error : null"
          v-model="propostaRecursosHumanos.remuneracao"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira uma remuneração</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Escalão" label-for="inputEscalao">
        <b-form-input
          id="inputEscalao"
          :state="$v.propostaRecursosHumanos.escalao.$dirty ? !$v.propostaRecursosHumanos.escalao.$error : null"
          v-model="propostaRecursosHumanos.escalao"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira um escalão</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Índice" label-for="inputIndice">
        <b-form-input
          id="inputIndice"
          :state="$v.propostaRecursosHumanos.indice.$dirty ? !$v.propostaRecursosHumanos.indice.$error : null"
          v-model="propostaRecursosHumanos.indice"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira um índice</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Número de funcionário" label-for="inputNumero">
        <b-form-input
          id="inputNumero"
          :state="$v.propostaRecursosHumanos.numero_funcionario.$dirty ? !$v.propostaRecursosHumanos.numero_funcionario.$error : null"
          v-model="propostaRecursosHumanos.numero_funcionario"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira um número para o funcionario</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Índice" label-for="inputIndice">
        <b-form-input
          id="inputIndice"
          :state="$v.propostaRecursosHumanos.indice.$dirty ? !$v.propostaRecursosHumanos.indice.$error : null"
          v-model="propostaRecursosHumanos.indice"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira um índice</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Contratação comunicada" class="mt-5">
        <b-form-checkbox
          id="checkboxContratacaoComunicada"
          v-model="propostaRecursosHumanos.contratacao_comunicada"
          name="checkboxContratacaoComunicada"
          value="1"
          unchecked-value="0"
          :state="$v.propostaRecursosHumanos.contratacao_comunicada.$dirty ? !$v.propostaRecursosHumanos.contratacao_comunicada.$error : null"
        >Reconheço o interesse e a necessidade da contratação/renovação</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de selecionar este campo</b-form-invalid-feedback>
      </b-form-group>

      
    </div>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
export default {
  data() {
    return {
      propostaRecursosHumanos: {
        remuneracao: "",
        escalao: "",
        indice: "",
        numero_funcionario: "",
        contratacao_comunicada: "",
        inscricao_seguranca_social: "",
        inscricao_caixa_geral_aposentacoes: "",
        despacho_presidente_ipl: "",
        contrato_redigido: "",
        contrato_anexo: "",
        cessacao_social: "",
        NISS_ou_numero_CGA: "",
        data_nascimento: "",
        numero_CC: "",
        email: "",
        dados_GIAF_carregados_por: "",
        data_carregamento_dados_GIAF: ""
      }
    };
  },
  validations:{
      propostaRecursosHumanos:{
        remuneracao: { required },
        escalao: { required },
        indice: { required },
        numero_funcionario: { required },
        contratacao_comunicada: { required },
        inscricao_seguranca_social: { required },
        inscricao_caixa_geral_aposentacoes: { required },
        despacho_presidente_ipl: { required },
        contrato_redigido: { required },
        contrato_anexo: { required },
        cessacao_social: { required },
        NISS_ou_numero_CGA: { required },
        data_nascimento: { required },
        numero_CC: { required },
        email: { required },
        dados_GIAF_carregados_por: { required },
        data_carregamento_dados_GIAF: { required }
      }
  }
};
</script>