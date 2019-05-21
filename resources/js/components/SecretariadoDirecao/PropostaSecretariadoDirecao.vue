<template>
  <div>
    <h2>Convite para o docente a ser contratado</h2>
    <b-form-group label="Convite para o docente">
      <b-form-textarea v-model="convite" :state="$v.convite.$dirty ? !$v.convite.$error : null"></b-form-textarea>
      <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher o convite!</b-form-invalid-feedback>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="finalizarConvite(convite)"
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
      convite: ""
    };
  },
  methods: {
    finalizarConvite(convite) {
      this.$v.convite.$touch();
      if (!this.$v.convite.$invalid) {
           let confirmacao = confirm(
          "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
        );

      }
    }
  },
  validations: {
    convite: { required }
  }
};
</script>