<template>
  <div class="jumbotron">
    <h2>Convite para o docente a ser contratado</h2>

    <b-form-group label="Email" label-for="inputEmail">
      <b-form-input id="inputEmail" v-model="propostaSelecionada.email" :readonly="true"></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">O Email é obrigatório!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Convite para o docente">
      <b-form-textarea
        v-model="propostaSecretariadoDirecao.convite"
        :state="$v.propostaSecretariadoDirecao.convite.$dirty ? !$v.propostaSecretariadoDirecao.convite.$error : null"
      ></b-form-textarea>
      <b-form-invalid-feedback id="input-1-live-feedback">Tem de preencher o convite!</b-form-invalid-feedback>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="finalizarConvite(propostaSecretariadoDirecao)"
    >
      Finalizar
      <i class="fas fa-arrow-right"></i>
    </button>
  </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
  props: ["propostaSelecionada"],
  data() {
    return {
      propostaSecretariadoDirecao: {
        convite: ""
      },
      novoUserBD: {
        name: "",
        username: "",
        roleDB: "docente_temp",
        role:"docente",
        password: "",
        email: "",
        unidade_organica:"",
        blocked:0,
      }
    };
  },
    validations: {
    propostaSecretariadoDirecao: {
      convite: { required }
    }
  },
  methods: {
    finalizarConvite(propostaSecretariadoDirecao) {
      this.$v.propostaSecretariadoDirecao.convite.$touch();
      if (!this.$v.propostaSecretariadoDirecao.convite.$invalid) {
        let confirmacao = confirm(
          "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
        );
        if (confirmacao) {
          axios
            .post(
              "/api/secretariadoDirecao/propostaSecretariadoDirecao",
              propostaSecretariadoDirecao
            )
            .then(response => {
              /*
              this.$socket.emit("email-rh", {
                msg: "Pedido de email enviado..."
              }); // raise an event on the server
              */
              console.log(response);
              let idPropostaSecretariadoDirecao = response.data.id_proposta_secretariado_direcao;
              axios
                .patch(
                  "/api/propostaSecretariadoDirecao/" + idPropostaSecretariadoDirecao + 
                  "/" +this.propostaSelecionada.id
                )
                .then(response => {
                  this.novoUserBD.name = this.propostaSelecionada.nome_completo;
                  this.novoUserBD.password = this.propostaSelecionada.numero_telefone;
                  this.novoUserBD.username = this.propostaSelecionada.nome_completo;
                  this.novoUserBD.unidade_organica = this.propostaSelecionada.unidade_organica;
                  this.novoUserBD.email = this.propostaSelecionada.email;
                  axios.post('/api/users/criarUserTemporario', this.novoUserBD).then(response => {
                    this.$socket.emit("email-docente", {
                      nome: this.propostaSelecionada.nome_completo,
                      email:this.propostaSelecionada.email
                    }); // raise an event on the server
                  })                  
                });
            });
        }
      }
    }
  },
};
</script>