<template>
  <div>
    <div class="jumbotron">
      <h2>Fundamentação Coordenador Departamento</h2>

      <b-form-group
        label="Fundamentação"
        label-for="inputFundCoordDepartamento"
      >
        <b-form-input
          id="inputFundCoordDepartamento"
          :state="$v.propostaProponente.fundamentacao_coordenador_departamento.$dirty ? 
        !$v.propostaProponente.fundamentacao_coordenador_departamento.$error : null"
          v-model="propostaProponente.fundamentacao_coordenador_departamento"
        ></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Insira a fundamentação</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Data de assinatura" label-for="inputData">
      <b-form-input id="inputData" type="date" v-model="propostaProponente.data_de_assinatura_coordenador_departamento">

      </b-form-input>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="inserirFundamentacao(propostaProponente)"
    >
      Submeter
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
        fundamentacao_coordenador_departamento: "",
        data_de_assinatura_coordenador_departamento:"",
        segundo_proponente: this.$store.state.user.name,
      }
    };
  },
  validations: {
    propostaProponente: {
      fundamentacao_coordenador_departamento: { required },
      data_de_assinatura_coordenador_departamento: { required },
    }
  },
  methods: {
    inserirFundamentacao(propostaProponente){
      this.$v.propostaProponente.$touch();
        if (!this.$v.propostaProponente.$invalid) {
       this.$swal.fire({title:'Tem a certeza que pretende submeter estes dados?',
                        text: 'Não poderá realizar mais nenhuma alteração',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'}).then((result) => {
          if(result.value){
          axios.put('/api/propostaProponente/fundamentacaoCoordenadorDepartamento/'+
          this.propostaSelecionada.id_proposta_proponente, this.propostaProponente).then(response => {
            this.$swal('Sucesso', 'Fundamentação inserida com sucesso', 'success');
            this.$socket.emit("email-diretor", {
                          msg: "Pedido de email enviado..."
                        });
            this.$emit('voltarProponentes');
          });
        }
        });
      }
    }
  }
};
</script>