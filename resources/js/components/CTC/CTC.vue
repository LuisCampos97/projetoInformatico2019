<template>
  <div>
    <h2>Aprovação por parte do conselho Tecnico-Cientifico para esta proposta</h2>
    <b-form-group label="Votos a favor" label-for="inputVotosAFavor">
      <b-form-input
        id="inputVotosAFavor"
        :state="$v.propostaCTC.votos_a_favor.$dirty ? !$v.propostaCTC.votos_a_favor.$error : null"
        v-model="propostaCTC.votos_a_favor"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Votos a favor obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Votos contra" label-for="inputVotosContra">
      <b-form-input
        id="inputVotosContra"
        :state="$v.propostaCTC.votos_contra.$dirty ? !$v.propostaCTC.votos_contra.$error : null"
        v-model="propostaCTC.votos_contra"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Votos contra obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Votos brancos" label-for="inputVotosBrancos">
      <b-form-input
        id="inputVotosBrancos"
        :state="$v.propostaCTC.votos_brancos.$dirty ? !$v.propostaCTC.votos_brancos.$error : null"
        v-model="propostaCTC.votos_brancos"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Votos brancos obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Votos nulos" label-for="inputVotosNulos">
      <b-form-input
        id="inputVotosNulos"
        :state="$v.propostaCTC.votos_nulos.$dirty ? !$v.propostaCTC.votos_nulos.$error : null"
        v-model="propostaCTC.votos_nulos"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Votos nulos obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Aprovação">
      <b-form-radio-group v-model="propostaCTC.aprovacao" :options="aprovacaoArray"></b-form-radio-group>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="finalizarAprovacaoCTC(propostaCTC)"
    >
      Seguinte
      <i class="fas fa-arrow-right"></i>
    </button>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  data() {
    return {
      propostaCTC: {
        votos_a_favor: "",
        votos_contra: "",
        votos_brancos: "",
        votos_nulos: "",
        aprovacao: ""
      },
      aprovacaoArray: [
        { text: "Aprovado", value: "aprovado" },
        { text: "Reprovado", value: "reprovado" }
      ]
    };
  },
  validations: {
    propostaCTC: {
      votos_a_favor: { required },
      votos_contra: { required },
      votos_brancos: { required },
      votos_nulos: { required },
      aprovacao: { required }
    }
  },
  methods: {
      finalizarAprovacaoCTC(propostaCTC){
          
      }
  },
};
</script>