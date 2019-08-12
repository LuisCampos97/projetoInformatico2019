<template>
  <div class="jumbotron">
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

    <b-form-group label="Ata da reunião do Conselho Tecnico-Científico (PDF)">
      <b-form-file
        v-model="ataCTC"
        placeholder="Escolha um ficheiro"
        drop-placeholder="Arraste para aqui um ficheiro"
        name="ataCTC"
        v-validate="{ required: true }"
        :state="validateState('ataCTC')"
        @change="onFileSelected"
      ></b-form-file>
    </b-form-group>

    <b-form-group label="Data de assinatura" label-for="inputData">
      <b-form-input id="inputData" type="date" v-model="propostaCTC.data_assinatura"></b-form-input>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="finalizarAprovacaoCTC(propostaCTC)"
    >
      Submeter
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
      propostaCTC: {
        votos_a_favor: "",
        votos_contra: "",
        votos_brancos: "",
        votos_nulos: "",
        aprovacao: "",
        data_assinatura: ""
      },
      
      ficheiro: {
        ata: {},
      },
      ficheiros:[],
      ataCTC:"",
      aprovacaoArray: [
        { text: "Aprovado", value: "aprovado" },
        { text: "Nao aprovado", value: "nao aprovado" }
      ]
    };
  },
  validations: {
    propostaCTC: {
      votos_a_favor: { required },
      votos_contra: { required },
      votos_brancos: { required },
      votos_nulos: { required },
      aprovacao: { required },
      data_assinatura: { required }
    }
    //ata: { required }
  },
  methods: {
    validateState(ref) {
      return this.veeErrors.has(ref) ? false : null;
    },
    onFileSelected(event) {
      this.ficheiros[event.target.name] = event.target.files[0];
    },

    finalizarAprovacaoCTC(propostaCTC) {

      this.ficheiro.ata = new FormData();
      this.ficheiro.ata.append("file", this.ficheiros["ataCTC"]);
      this.ficheiro.ata.append("descricao", "Ata do CTC");
    
      let confirmacao = confirm(
        "Tem a certeza que pretende submeter esta proposta? Não pode realizar mais alterações"
      );
      if (confirmacao) {
        this.$v.propostaCTC.$touch();
        if (!this.$v.propostaCTC.$invalid) {
          axios
            .post("/api/ctc/propostaCTC", this.propostaCTC)
            .then(response => {
              let proposta_ctc_id = response.data.id_proposta_ctc;
              let aprovacao = response.data.aprovacao.replace(' ', '');
              this.ficheiro.ata.append("proposta_id", proposta_ctc_id);
              axios.post('/api/ficheiro', this.ficheiro.ata).then(response => {
                
              });
              axios
                .patch(
                  "/api/propostaCTC/" +
                    proposta_ctc_id +
                    "/" +
                    this.propostaSelecionada.id+"/"+aprovacao
                )
                .then(response => {});
            })
            .catch(error => {
              console.log(error);
            });
          this.$socket.emit("email-secretariado", {
            msg: "Pedido de email enviado..."
          }); // raise an event on the server
        }
      }
    }
  }
};
</script>