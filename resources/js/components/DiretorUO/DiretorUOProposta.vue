<template>
  <div>
    <h2>Reconhecimento e Parecer sobre esta proposta</h2>
    <b-form-group label="Reconhecimento" class="mt-5">
      <b-form-checkbox
        id="checkboxReconhecimento"
        v-model="propostaDiretor.reconhecimento"
        name="checkboxReconhecimento"
        value="true"
        unchecked-value="false"
      >Reconheço o interesse e a necessidade da contratação/renovação</b-form-checkbox>
      <b-form-invalid-feedback id="input-1-live-feedback">Tem de reconhecer a proposta</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Parecer">
      <b-form-radio-group v-model="propostaDiretor.parecer" :options="parecerArray"></b-form-radio-group>
      <b-form-invalid-feedback id="input-1-live-feedback">Selecione a opção do parecer</b-form-invalid-feedback>
    </b-form-group>

     <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="finalizarParecer(propostaDiretor)"
      >
        Finalizar
        <i class="fas fa-arrow-right"></i>
      </button>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      propostaDiretor: {
        reconhecimento: "",
        parecer: "",
      },
      parecerArray: [
        { text: "Favoravel", value: "Favoravel" },
        { text: "Desfavorável", value: "Desfavoravel" }
      ]
    };
  },
  validations: {
    propostaDiretor: {
      reconhecimento: { required },
      parecer: { required }
    }
  },

  methods: {
    finalizarParecer(propostaDiretor){
      
    }
  }
};
</script>