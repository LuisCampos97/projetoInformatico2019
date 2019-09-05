<template>
  <div>
    <h2 class="pb-4">Ficheiros a inserir</h2>
    <h4 class="pb-4"> Por favor, insira os seguintes ficheiros para dar continuidade à proposta
        de contratação/renovação/alteração
    </h4>
    <b-form-group label="NIF" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileNIF"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroNIF"
          v-validate="{ required: true }"
          :state="validateState('ficheiroNIF')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroNIF"
          @click="downloadFicheiro(ficheiroNIF.proposta_id, 'Ficheiro NIF')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro NIF
        </b-button>
      </b-form-group>

      <b-form-group label="N.º de CGA/SS" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileNumeroCGA"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroNumeroCGA"
          v-validate="{ required: true }"
          :state="validateState('ficheiroNumeroCGA')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroNumeroCGA"
          @click="downloadFicheiro(ficheiroNumeroCGA.proposta_id, 'Ficheiro Nº CGA/SS')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro CGA/SS
        </b-button>
      </b-form-group>

      <b-form-group label="Cópia do IBAN/NIB" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileCopiaIBAN"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroCopiaIBAN"
          v-validate="{ required: true }"
          :state="validateState('ficheiroCopiaIBAN')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCopiaIBAN"
          @click="downloadFicheiro(ficheiroCopiaIBAN.proposta_id, 'Ficheiro Cópia IBAN')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro IBAN/NIB
        </b-button>
      </b-form-group>

      <b-form-group label="Cópia do CC/BI" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileCopiaCC"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroCopiaCC"
          v-validate="{ required: true }"
          :state="validateState('ficheiroCopiaCC')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCopiaCC"
          @click="downloadFicheiro(ficheiroCopiaCC.proposta_id, 'Ficheiro Cópia CC')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro CC/BI
        </b-button>
      </b-form-group>

      <b-form-group label="Certificado de Registo Criminal" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileRegistoCriminal"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroRegistoCriminal"
          v-validate="{ required: true }"
          :state="validateState('ficheiroRegistoCriminal')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRegistoCriminal"
          @click="downloadFicheiro(ficheiroRegistoCriminal.proposta_id, 'Ficheiro Registo Criminal')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Registo Criminal
        </b-button>
      </b-form-group>

      <b-form-group label="Certificado de Robustez Física" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileRobustezFisica"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroRobustezFisica"
          v-validate="{ required: true }"
          :state="validateState('ficheiroRobustezFisica')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRobustezFisica"
          @click="downloadFicheiro(ficheiroRobustezFisica.proposta_id, 'Ficheiro Robustez Física')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Robustez Física
        </b-button>
      </b-form-group>

      <b-form-group label="Cópia do Boletim de Vacinas" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileCopiaBoletimVacinas"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroCopiaBoletimVacinas"
          v-validate="{ required: true }"
          :state="validateState('ficheiroCopiaBoletimVacinas')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroCopiaBoletimVacinas"
          @click="downloadFicheiro(ficheiroCopiaBoletimVacinas.proposta_id, 'Ficheiro Boletim Vacinas')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Boletim Vacinas
        </b-button>
      </b-form-group>

      <b-form-group label="Ficha de Identificação" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fichaIdentificacao"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroFichaIdentificacao"
          v-validate="{ required: true }"
          :state="validateState('ficheiroFichaIdentificacao')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroFichaIdentificacao"
          @click="downloadFicheiro(ficheiroFichaIdentificacao.proposta_id, 'Ficheiro Ficha Identificacao')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficha Identificação
        </b-button>
      </b-form-group>

      <b-form-group label="Declaração Artº 99 do IRS" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileDeclaracaoIRS"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroDeclaracaoIRS"
          v-validate="{ required: true }"
          :state="validateState('ficheiroDeclaracaoIRS')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroDeclaracaoIRS"
          @click="downloadFicheiro(ficheiroDeclaracaoIRS.proposta_id, 'Ficheiro Declaracao IRS')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Declaração IRS
        </b-button>
      </b-form-group>

      <b-form-group label="Declaração Comunic.Direitos/Renúncia ADSE" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileDeclaracaoRenunciaADSE"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroDeclaracaoRenunciaADSE"
          v-validate="{ required: true }"
          :state="validateState('ficheiroDeclaracaoRenunciaADSE')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroDeclaracaoRenunciaADSE"
          @click="downloadFicheiro(ficheiroDeclaracaoRenunciaADSE.proposta_id, 'Ficheiro Renuncia ADSE')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Renuncia ADSE
        </b-button>
      </b-form-group>

      <b-form-group label="Resposta à consulta das outras Escolas" class="mt-3">
        <b-form-file
          v-model="ficheirosAInserir.fileRespostaOutrasEscolas"
          placeholder="Escolha um ficheiro"
          drop-placeholder="Arraste para aqui um ficheiro"
          browse-text="Procurar"
          name="ficheiroRespostaOutrasEscolas"
          v-validate="{ required: true }"
          :state="validateState('ficheiroRespostaOutrasEscolas')"
          @change="onFileSelected"
        ></b-form-file>
      </b-form-group>
      <b-form-group>
        <b-button
          size="md"
          variant="dark"
          v-if="ficheiroRespostaOutrasEscolas"
          @click="downloadFicheiro(ficheiroRespostaOutrasEscolas.proposta_id, 'Ficheiro Resposta Consulta Outras Escolas')"
        >
          <i class="far fa-file-pdf"></i> Atual Ficheiro Resposta Consulta Outras Escolas
        </b-button>
      </b-form-group>

    <button
        class="btn btn-success mt-3 font-weight-bold"
        v-on:click.prevent="submeter(ficheirosAInserir)">
        Submeter Ficheiros
      </button>

  </div>
</template>
<script>
export default {
  data() {
    return {
      propostaDesteProponente:"",
      proposta:"",
      ficheirosAInserir:{
        fileNIF:{},
        fileNumeroCGA:{},
        fileCopiaCC:{},
        fileCopiaIBAN:{},
        fileRegistoCriminal:{},
        fileRobustezFisica:{},
        fileCopiaBoletimVacinas:{},
        fichaIdentificacao:{},
        fileDeclaracaoIRS:{},
        fileDeclaracaoRenunciaADSE:{},
        fileRespostaOutrasEscolas:{},
      },
      ficheiros:[],
      ficheiroNIF:"",
      ficheiroNumeroCGA:"",
      ficheiroCopiaCC:"",
      ficheiroCopiaIBAN:"",
      ficheiroRegistoCriminal:"",
      ficheiroRobustezFisica:"",
      ficheiroCopiaBoletimVacinas:"",
      ficheiroFichaIdentificacao:"",
      ficheiroDeclaracaoIRS:"",
      ficheiroDeclaracaoRenunciaADSE:"",
      ficheiroRespostaOutrasEscolas:"",
    };
  },
  methods: {
    validateState(ref) {
      return this.veeErrors.has(ref) ? false : null;
    },
    downloadFicheiro(proposta_id, descricao) {
      axios
        .get("/api/downloadFicheiro/" + proposta_id + "/" + descricao, {
          responseType: "arraybuffer"
        })
        .then(response => {
          let blob = new Blob([response.data]);
          let link = document.createElement("a");
          link.href = window.URL.createObjectURL(blob);
          link.download = descricao + ".pdf";
          link.click();
        });
    },
    onFileSelected(event) {
      this.ficheiros[event.target.name] = event.target.files[0];
    },
    submeter(ficheirosAInserir){

      this.$swal.fire({title:'Tem a certeza que pretende submeter estes dados?',
                        text: 'Não poderá realizar mais nenhuma alteração',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sim',
                        cancelButtonText: 'Não'}).then((result) => {
          if(result.value){
              this.ficheirosAInserir.fileNIF = new FormData();
              this.ficheirosAInserir.fileNIF.append(
                "file",
                this.ficheiros["ficheiroNIF"]
              );
              this.ficheirosAInserir.fileNIF.append(
                "descricao",
                "Ficheiro NIF"
              );
              this.ficheirosAInserir.fileNIF.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileNumeroCGA = new FormData();
              this.ficheirosAInserir.fileNumeroCGA.append(
                "file",
                this.ficheiros["ficheiroNumeroCGA"]
              );
              this.ficheirosAInserir.fileNumeroCGA.append(
                "descricao",
                "Ficheiro Nº CGA/SS"
              );
              this.ficheirosAInserir.fileNumeroCGA.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileCopiaCC = new FormData();
              this.ficheirosAInserir.fileCopiaCC.append(
                "file",
                this.ficheiros["ficheiroCopiaCC"]
              );
              this.ficheirosAInserir.fileCopiaCC.append(
                "descricao",
                "Ficheiro Cópia CC"
              );
              this.ficheirosAInserir.fileCopiaCC.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileCopiaIBAN = new FormData();
              this.ficheirosAInserir.fileCopiaIBAN.append(
                "file",
                this.ficheiros["ficheiroCopiaIBAN"]
              );
              this.ficheirosAInserir.fileCopiaIBAN.append(
                "descricao",
                "Ficheiro Cópia IBAN"
              );
              this.ficheirosAInserir.fileCopiaIBAN.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileRegistoCriminal = new FormData();
              this.ficheirosAInserir.fileRegistoCriminal.append(
                "file",
                this.ficheiros["ficheiroRegistoCriminal"]
              );
              this.ficheirosAInserir.fileRegistoCriminal.append(
                "descricao",
                "Ficheiro Registo Criminal"
              );
              this.ficheirosAInserir.fileRegistoCriminal.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileRobustezFisica = new FormData();
              this.ficheirosAInserir.fileRobustezFisica.append(
                "file",
                this.ficheiros["ficheiroRobustezFisica"]
              );
              this.ficheirosAInserir.fileRobustezFisica.append(
                "descricao",
                "Ficheiro Robustez Física"
              );
              this.ficheirosAInserir.fileRobustezFisica.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileCopiaBoletimVacinas = new FormData();
              this.ficheirosAInserir.fileCopiaBoletimVacinas.append(
                "file",
                this.ficheiros["ficheiroCopiaBoletimVacinas"]
              );
              this.ficheirosAInserir.fileCopiaBoletimVacinas.append(
                "descricao",
                "Ficheiro Boletim Vacinas"
              );
              this.ficheirosAInserir.fileCopiaBoletimVacinas.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fichaIdentificacao = new FormData();
              this.ficheirosAInserir.fichaIdentificacao.append(
                "file",
                this.ficheiros["ficheiroFichaIdentificacao"]
              );
              this.ficheirosAInserir.fichaIdentificacao.append(
                "descricao",
                "Ficheiro Ficha Identificacao"
              ); 
              this.ficheirosAInserir.fichaIdentificacao.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileDeclaracaoIRS = new FormData();
              this.ficheirosAInserir.fileDeclaracaoIRS.append(
                "file",
                this.ficheiros["ficheiroDeclaracaoIRS"]
              );
              this.ficheirosAInserir.fileDeclaracaoIRS.append(
                "descricao",
                "Ficheiro Declaracao IRS"
              );    
              this.ficheirosAInserir.fileDeclaracaoIRS.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );

              this.ficheirosAInserir.fileDeclaracaoRenunciaADSE = new FormData();
              this.ficheirosAInserir.fileDeclaracaoRenunciaADSE.append(
                "file",
                this.ficheiros["ficheiroDeclaracaoRenunciaADSE"]
              );
              this.ficheirosAInserir.fileDeclaracaoRenunciaADSE.append(
                "descricao",
                "Ficheiro Renuncia ADSE"
              );     
              this.ficheirosAInserir.fileDeclaracaoRenunciaADSE.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );       

              this.ficheirosAInserir.fileRespostaOutrasEscolas = new FormData();
              this.ficheirosAInserir.fileRespostaOutrasEscolas.append(
                "file",
                this.ficheiros["ficheiroRespostaOutrasEscolas"]
              );
              this.ficheirosAInserir.fileRespostaOutrasEscolas.append(
                "descricao",
                "Ficheiro Resposta Consulta Outras Escolas"
              );    
              this.ficheirosAInserir.fileRespostaOutrasEscolas.append(
                "proposta_id",
                this.propostaDesteProponente.id_proposta_proponente
              );             
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileNIF).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileNumeroCGA).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileCopiaCC).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileCopiaIBAN).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileRegistoCriminal).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileRobustezFisica).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileCopiaBoletimVacinas).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fichaIdentificacao).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileDeclaracaoIRS).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileDeclaracaoRenunciaADSE).then(response => {

              });
              axios.post('/api/ficheiro', this.ficheirosAInserir.fileRespostaOutrasEscolas).then(response => {
                axios.put('/api/updateFicheirosDocente/'+this.proposta.id).then(response => {
                  axios.put('/api/block/' + this.$store.state.user.id).then(response => {
                    axios.post('/api/logout').then(response => {
                    this.$swal('Sucesso', 'Ficheiros submetidos com sucesso!!', 'success')
                    this.$store.commit("clearUserAndToken");
                    this.$socket.emit("email-recursos", {
                      msg: "Pedido de email enviado..."
                    });
                    this.$router.push({
                      name: "login"
                    });
                })
            });
          })
        });
      }
    });
      
    }
  },
  mounted() {
    this.$swal('Atenção', 'Tem apenas uma oportunidade de submeter corretamente todos os ficheiros necessários', 'info')
    axios.get('/api/getPropostaParaNovoDocente/'+this.$store.state.user.email).then(response => {
      this.propostaDesteProponente = response.data[0];
      //console.log(this.propostaDesteProponente.id_proposta_proponente);
      axios.get('/api/propostaDePropostaProponente/'+this.propostaDesteProponente.id_proposta_proponente)
      .then(response => {
        this.proposta = response.data;
      })
    });
  }
};

</script>