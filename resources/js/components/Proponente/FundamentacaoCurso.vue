<template>
  <div>
    <div class="jumbotron">
      <h2>Fundamentação Coordenador Curso</h2>

      <b-form-group label="Fundamentação" label-for="inputFundCoordCurso">
        <b-form-input
          id="inputFundCoordCurso"
          :state="$v.propostaProponente.fundamentacao_coordenador_curso.$dirty ? 
        !$v.propostaProponente.fundamentacao_coordenador_curso.$error : null"
          v-model="propostaProponente.fundamentacao_coordenador_curso"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira a fundamentação</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Data de assinatura" label-for="inputData">
        <b-form-input
          id="inputData"
          type="date"
          v-model="propostaProponente.data_de_assinatura_coordenador_de_curso"
        ></b-form-input>
      </b-form-group>

      <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="inserirFundamentacao(propostaProponente)"
      >
        Finalizar
        <i class="fas fa-arrow-right"></i>
      </button>
    </div>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  props: ["propostaSelecionada"],
  data() {
    return {
      propostaProponente: {
        fundamentacao_coordenador_curso: "",
        data_de_assinatura_coordenador_de_curso:"",
      }
    };
  },
  validations: {
    propostaProponente: {
      fundamentacao_coordenador_curso: { required },
      data_de_assinatura_coordenador_de_curso: { required },
    }
  },
  methods: {
    inserirFundamentacao(propostaProponente){
       let confirmacao = confirm(
        "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
      );
      if (confirmacao) {
        this.$v.propostaProponente.$touch();
        if (!this.$v.propostaProponente.$invalid) {
          axios.put('/api/propostaProponente/fundamentacaoCoordenadorCurso/'+
          this.propostaSelecionada.id, this.propostaProponente).then(response => {

          });
        }
      }
    }
  }
};
</script>