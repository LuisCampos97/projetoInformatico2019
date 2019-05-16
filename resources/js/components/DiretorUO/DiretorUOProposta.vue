<template>
  <div>
    <div class="jumbotron">
      <h3>Reconhecimento e Parecer sobre esta proposta</h3>
      <b-form-group label="Reconhecimento" class="mt-5">
        <b-form-checkbox
          id="checkboxReconhecimento"
          v-model="propostaDiretor.reconhecimento"
          name="checkboxReconhecimento"
          value="1"
          unchecked-value="0"
          :state="$v.propostaDiretor.reconhecimento.$dirty ? !$v.propostaDiretor.reconhecimento.$error : null"
        >Reconheço o interesse e a necessidade da contratação/renovação</b-form-checkbox>
        <b-form-invalid-feedback id="input-1-live-feedback">Tem de reconhecer a proposta</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Parecer">
        <b-form-radio-group v-model="propostaDiretor.parecer"
            :state="$v.propostaDiretor.parecer.$dirty ? !$v.propostaDiretor.parecer.$error : null"
            :options="parecerArray"></b-form-radio-group>
        <b-form-invalid-feedback id="input-1-live-feedback">Selecione a opção do parecer</b-form-invalid-feedback>
      </b-form-group>

      <b-form-group label="Data assinatura">
        <b-form-input type="date"
            :state="$v.propostaDiretor.data_assinatura.$dirty ? !$v.propostaDiretor.data_assinatura.$error : null"
            v-model="propostaDiretor.data_assinatura"></b-form-input>
        <b-form-invalid-feedback id="input-1-live-feedback">Selecione a data de assinatura</b-form-invalid-feedback>
      </b-form-group>
  
      <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="finalizarParecer(propostaDiretor)"
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
      propostaDiretor: {
        reconhecimento: "",
        parecer: "",
        data_assinatura: ""
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
      parecer: { required },
      data_assinatura: { required }
    }
  },

  methods: {
    finalizarParecer(propostaDiretor) {
      this.$v.propostaDiretor.$touch();
      if (!this.$v.propostaDiretor.$invalid) {
        let confirmacao = confirm(
          "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
        );
        if (confirmacao) {
          axios
            .post("/api/diretorUO/propostaDiretor/", this.propostaDiretor)
            .then(response => {
              axios
                .patch(
                  "/api/proposta/" +
                    parseInt(response.data.id) +
                    "/" +
                    this.propostaSelecionada.id
                )
                .then(response => {
                  this.$socket.emit("email-ctc", {
                    msg: "Pedido de email enviado..."
                  }); // raise an event on the server
                });
            })
            .catch(error => {
              console.log(error);
            });
        }
      }
    }
  }
};
</script>