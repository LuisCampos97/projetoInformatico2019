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

      <b-form-group label="Inscrição">
        <b-form-radio-group
          v-model="propostaRecursosHumanos.inscricao"
          :options="inscricao_array"
          stacked
        ></b-form-radio-group>
      </b-form-group>

      <b-form-group label="Despacho do Sr.Presidente do IPL" label-for="inputDespacho">
        <b-form-input
          type="date"
          id="inputDespacho"
          :state="$v.propostaRecursosHumanos.despacho_presidente_ipl.$dirty ? !$v.propostaRecursosHumanos.despacho_presidente_ipl.$error : null"
          v-model="propostaRecursosHumanos.despacho_presidente_ipl"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="mt-5">
        <b-form-checkbox
          id="checkboxContratacaoComunicada"
          v-model="propostaRecursosHumanos.contratacao_comunicada"
          name="checkboxContratacaoComunicada"
          value="1"
          unchecked-value="0"
          :state="$v.propostaRecursosHumanos.contratacao_comunicada.$dirty ? !$v.propostaRecursosHumanos.contratacao_comunicada.$error : null"
        >Contratação comunicada</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de selecionar este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="mt-5">
        <b-form-checkbox
          id="checkBoxContratoRedigido"
          v-model="propostaRecursosHumanos.contrato_redigido"
          name="checkBoxContratoRedigido"
          value="1"
          unchecked-value="0"
          :state="$v.propostaRecursosHumanos.contrato_redigido.$dirty ? !$v.propostaRecursosHumanos.contrato_redigido.$error : null"
        >Contrato redigido</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de selecionar este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="mt-5">
        <b-form-checkbox
          id="checkBoxContratoAnexo"
          v-model="propostaRecursosHumanos.contrato_anexo"
          name="checkBoxContratoAnexo"
          value="1"
          unchecked-value="0"
          :state="$v.propostaRecursosHumanos.contrato_anexo.$dirty ? !$v.propostaRecursosHumanos.contrato_anexo.$error : null"
        >Contrato anexo</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de selecionar este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group class="mt-5">
        <b-form-checkbox
          id="checkBoxContratoCessacaoSocial"
          v-model="propostaRecursosHumanos.cessacao_social"
          name="checkBoxContratoCessacaoSocial"
          value="1"
          unchecked-value="0"
          :state="$v.propostaRecursosHumanos.cessacao_social.$dirty ? !$v.propostaRecursosHumanos.cessacao_social.$error : null"
        >Cessação Social</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de selecionar este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="NISS ou nº Caixa Geral Aposentações" label-for="inputNissOuCGA">
        <b-form-input
          id="inputNissOuCGA"
          :state="$v.propostaRecursosHumanos.NISS_ou_numero_CGA.$dirty ? !$v.propostaRecursosHumanos.NISS_ou_numero_CGA.$error : null"
          v-model="propostaRecursosHumanos.NISS_ou_numero_CGA"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Data de nascimento" label-for="inputDataNascimento">
        <b-form-input
          type="date"
          id="inputDataNascimento"
          :state="$v.propostaRecursosHumanos.data_nascimento.$dirty ? !$v.propostaRecursosHumanos.data_nascimento.$error : null"
          v-model="propostaRecursosHumanos.data_nascimento"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Número cartão de cidadão" label-for="inputCC">
        <b-form-input
          id="inputCC"
          :state="$v.propostaRecursosHumanos.numero_CC.$dirty ? !$v.propostaRecursosHumanos.numero_CC.$error : null"
          v-model="propostaRecursosHumanos.numero_CC"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="E-mail pessoal" label-for="inputEmailPessoal">
        <b-form-input
          id="inputEmailPessoal"
          :state="$v.propostaRecursosHumanos.email_recursos_humanos.$dirty ? !$v.propostaRecursosHumanos.email_recursos_humanos.$error : null"
          v-model="propostaRecursosHumanos.email_recursos_humanos"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Dados carregados/atualizados no GIAF por:" label-for="inputDadosGIAF">
        <b-form-input
          id="inputDadosGIAF"
          :state="$v.propostaRecursosHumanos.dados_GIAF_carregados_por.$dirty ? !$v.propostaRecursosHumanos.dados_GIAF_carregados_por.$error : null"
          v-model="propostaRecursosHumanos.dados_GIAF_carregados_por"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Data" label-for="inputDataGIAF">
        <b-form-input
          type="date"
          id="inputDataGIAF"
          :state="$v.propostaRecursosHumanos.data_carregamento_dados_GIAF.$dirty ? !$v.propostaRecursosHumanos.data_carregamento_dados_GIAF.$error : null"
          v-model="propostaRecursosHumanos.data_carregamento_dados_GIAF"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher este campo</b-form-invalid-feedback>
      </b-form-group>

      <button class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="finalizarPropostaRecursosHumanos(propostaRecursosHumanos)">Finalizar
        <i class="fas fa-arrow-right"></i>
      </button>
      
    </div>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";
export default {
  props:["propostaSelecionada"],
  data() {
    return {
      inscricao_array: [
        { text: "Segurança Social", value: "seguranca_social" },
        { text: "Caixa Geral de Aposentações", value: "CGA" }
      ],
      propostaRecursosHumanos: {
        remuneracao: "",
        escalao: "",
        indice: "",
        numero_funcionario: "",
        contratacao_comunicada: "",
        inscricao: "",
        despacho_presidente_ipl: "",
        contrato_redigido: "",
        contrato_anexo: "",
        cessacao_social: "",
        NISS_ou_numero_CGA: "",
        data_nascimento: "",
        numero_CC: "",
        email_recursos_humanos: "",
        dados_GIAF_carregados_por: "",
        data_carregamento_dados_GIAF: ""
      }
    };
  },
  validations: {
    propostaRecursosHumanos: {
      remuneracao: { required },
      escalao: { required },
      indice: { required },
      numero_funcionario: { required },
      contratacao_comunicada: { required },
      inscricao: { required },
      despacho_presidente_ipl: { required },
      contrato_redigido: { required },
      contrato_anexo: { required },
      cessacao_social: { required },
      NISS_ou_numero_CGA: { required },
      data_nascimento: { required },
      numero_CC: { required },
      email_recursos_humanos: { required },
      dados_GIAF_carregados_por: { required },
      data_carregamento_dados_GIAF: { required }
    }
  },
  methods: {
    finalizarPropostaRecursosHumanos(propostaRecursosHumanos){
      this.$v.propostaRecursosHumanos.$touch();
      if (!this.$v.propostaRecursosHumanos.$invalid) {
        let confirmacao = confirm(
          "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
        );
        if (confirmacao) {
          axios.post('/api/recursosHumanos/propostaRecursosHumanos', propostaRecursosHumanos)
          .then(response => {
            console.log(response)
            let idPropostaRecursosHumanos = response.data.id_proposta_recursos_humanos;
            axios.patch('/api/propostaRecursosHumanos/' + idPropostaRecursosHumanos + "/" 
            + this.propostaSelecionada.id).then(response => {
              this.$socket.emit("email-recursos-humanos", {
                msg: "Pedido de email enviado..."
              });
            });
          });
        }
      }
    }
  },
};
</script>