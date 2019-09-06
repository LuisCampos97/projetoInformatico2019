<template>
  <div v-if="mostrarResumoProposta">
    <h2>
      <strong>Resumo da Proposta de contratação</strong>
    </h2>
    <br />
    <h4>
      <strong>Informações gerais</strong>
    </h4>
    <div class="jumbotron">
      <br />
      <h5>
        <strong>Tipo de contratação:</strong>
        {{ proposta.tipo_contrato }}
      </h5>
      <br />
      <h5>
        <strong>Unidade Organica:</strong>
        {{ proposta.unidade_organica }}
      </h5>
      <br />
      <h5>
        <strong>Nome completo:</strong>
        {{ proposta.nome_completo }}
      </h5>
      <br />
      <h5>
        <strong>Papel do docente:</strong>
        {{ proposta.role }}
      </h5>
    </div>
    <br />
    <h4>
      <strong>Unidades Curriculares</strong>
    </h4>
    <div>
      <table class="table">
        <thead>
          <th>Código</th>
          <th>Regime</th>
          <th>Turno</th>
          <th>Horas</th>
          <th>Horas Semestrais</th>
          <th>Tipo</th>
        </thead>
        <tbody>
          <tr v-for="(ucAUX) in unidadesCurriculares" :key="ucAUX.id">
            <td>{{ucAUX.codigo_uc}}</td>
            <td>{{ucAUX.regime}}</td>
            <td>{{ucAUX.turno}}</td>
            <td>{{ucAUX.horas}}</td>
            <td>{{ucAUX.horas_semestrais}}</td>
            <td>{{ucAUX.tipo}}</td>
          </tr>
        </tbody>
      </table>
      <br />
    </div>
    <br />
    <h4>
      <strong>Informações Especificas</strong>
    </h4>
    <br />
    <div class="jumbotron">
      <div v-if="proposta.role=='professor'">
        <h5>
          <strong>Tipo de professor:</strong>
          {{ propostaProponenteProfessor.role_professor }}
        </h5>
      </div>
      <br />
      <h5>
        <strong>Regime de prestação de serviços:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.regime_prestacao_servicos }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.regime_prestacao_servicos }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.regime_prestacao_servicos }}</h5>
      </div>
      <br />

      <div v-if="propostaProponenteProfessor">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteProfessor.percentagem_prestacao_servicos }}
      </div>

      <div v-if="propostaProponenteMonitor">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteMonitor.percentagem_prestacao_servicos }}
      </div>

      <div v-if="propostaProponenteAssistente">
        <h5>
          <strong>Percentagem de prestação de serviços:</strong>
        </h5>
        {{ propostaProponenteAssistente.percentagem_prestacao_servicos }}
      </div>
      <h5>
        <strong>Duração do contrato:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.duracao }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.duracao }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.duracao }}</h5>
      </div>
      <br />
      <h5>
        <strong>Periodo:</strong>
      </h5>

      <div v-if="propostaProponenteProfessor">
        <h5>{{ propostaProponenteProfessor.periodo }}</h5>
      </div>
      <div v-if="propostaProponenteAssistente">
        <h5>{{ propostaProponenteAssistente.periodo }}</h5>
      </div>
      <div v-if="propostaProponenteMonitor">
        <h5>{{ propostaProponenteMonitor.periodo }}</h5>
      </div>
      <br />
    </div>

    <!-- Coordenador de curso -->
    <div v-if="this.$store.state.user.roleDB == 'proponente_curso'" class="mt-5">
      <b-form-group>
        <b-form-checkbox
          v-model="fundamentacaoCheck"
        >Reconheço o interesse e a necessidade da contratação inicial/renovação</b-form-checkbox>
      </b-form-group>

      <div v-if="fundamentacaoCheck">
        <b-form-group label="Fundamentação">
          <b-form-textarea v-model="proposta.fundamentacao_coordenador_curso" rows="3" max-rows="6"
          :state="!$v.proposta.fundamentacao_coordenador_curso.$error && null"></b-form-textarea>
        </b-form-group>
        <b-form-group label="Data" label-for="inputData">
          <b-form-input
            id="inputData"
            type="date"
            :state="!$v.proposta.data_de_assinatura_coordenador_de_curso.$error && null"
            v-model="proposta.data_de_assinatura_coordenador_de_curso"
          ></b-form-input>
        </b-form-group>
      </div>
    </div>

    <!-- Coordenador de departamento -->

    <div v-if="this.$store.state.user.roleDB == 'proponente_departamento'" class="mt-5">
      <b-form-group>
        <b-form-checkbox
          v-model="fundamentacaoCheck"
        >Reconheço o interesse e a necessidade da contratação inicial/renovação</b-form-checkbox>
      </b-form-group>

      <div v-if="fundamentacaoCheck">
        <b-form-group label="Fundamentação">
          <b-form-textarea
            v-model="proposta.fundamentacao_coordenador_departamento"
            rows="3"
            :state="!$v.proposta.fundamentacao_coordenador_departamento.$error && null"
            max-rows="6"
          ></b-form-textarea>
        </b-form-group>
        <b-form-group label="Data" label-for="inputData">
          <b-form-input
            id="inputData"
            type="date"
            :state="!$v.proposta.data_de_assinatura_coordenador_departamento.$error && null"
            v-model="proposta.data_de_assinatura_coordenador_departamento"
          ></b-form-input>
        </b-form-group>
      </div>
    </div>

    <button class="btn btn-info" v-on:click.prevent="anterior">
      <i class="fas fa-arrow-left"></i> Anterior
    </button>

    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaProfessor(propostaProponenteProfessor)"
      @click="makeToast('success')"
      v-if="proposta.role=='professor'"
    >
      <i class="fas fa-save"></i> Submeter
    </button>
    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaAssistente(propostaProponenteAssistente)"
      @click="makeToast('success')"
      v-if="proposta.role=='assistente'"
    >
      <i class="fas fa-save"></i> Submeter
    </button>
    <button
      type="button"
      class="btn btn-success"
      v-on:click="submeterPropostaMonitor(propostaProponenteMonitor)"
      @click="makeToast('success')"
      v-if="proposta.role=='monitor'"
    >
      <i class="fas fa-save"></i> Submeter
    </button>
  </div>
</template>

<script src="/socket.io/socket.io.js">
</script>

<script>
import { required } from "vuelidate/lib/validators";
export default {
  props: [
    "proposta",
    "unidadesCurriculares",
    "propostaProponenteProfessor",
    "propostaProponenteAssistente",
    "propostaProponenteMonitor",
    "ficheiro"
  ],
  data() {
    return {
      idParaUcsPropostaProponente: "",
      fundamentacaoCheck: false,
      user: this.$store.state.user,
      mostrarResumoProposta: true,
      isLoading: false,
      successMessage: ""
    };
  },
  validations() {
    if (this.$store.state.user.roleDB == "proponente_departamento") {
      return {
        fundamentacaoCheck: { required },
        proposta: {
          data_de_assinatura_coordenador_departamento: { required },
          fundamentacao_coordenador_departamento: { required },
        },
      };
    } 
    if(this.$store.state.user.roleDB == "proponente_curso") {
      return {
        fundamentacaoCheck: { required },
        proposta: {
          data_de_assinatura_coordenador_de_curso: { required },
          fundamentacao_coordenador_curso: { required },
        },
      };
    }
  },
  methods: {
    voltar() {
      this.$emit("mostrarComponente", this.proposta);
      this.mostrarResumoProposta = false;
    },
    submeterPropostaProfessor(propostaProponenteProfessor) {
      if (this.unidadesCurriculares.length > 0) {
         this.$v.$touch();
        if (!this.$v.$invalid) {
        this.$swal.fire({
            title: "Tem a certeza que pretende submeter estes dados?",
            text: "Não poderá realizar mais nenhuma alteração",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim",
            cancelButtonText: "Não"
          })
          .then(result => {
            if (result.value) {
              if (this.$store.state.editarProposta) {
                //? Update Proposta Proponente
                axios.put("/api/updatePropostaProponente/" + this.proposta.id_proposta_proponente, this.proposta)
                  .then(response => {
                    this.idParaUcsPropostaProponente = response.data.id_proposta_proponente;

                    //? Eliminar UCs Proponentes  Antigas
                    axios.get('api/getUcsPropostaProponente/' + this.proposta.id_proposta_proponente)
                    .then(response => {
                      response.data.forEach(unidadeCurricular => {
                        axios.delete("/api/ucsPropostaProponente/" + unidadeCurricular.id_ucs_proposta_proponente).then(response => {});
                      });
                    })

                    //? Criar UCs Proponentes Novas
                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      axios
                        .post("/api/ucsPropostaProponente", unidadeCurricular)
                        .then(response => {});

                      this.propostaProponenteProfessor.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    //? Apagar Propostas Proponente de todas as roles
                    axios.put('/api/apagarPropostasProponente/'+this.idParaUcsPropostaProponente, this.proposta).then(response => {});

                    //? Update Proposta Proponente Professor
                    axios.get("/api/propostaProponenteProfessor/" + this.idParaUcsPropostaProponente).then(response => {
                      if(response.data.id_proposta_proponente_professor) {
                        axios
                      .put("/api/updatePropostaProponenteProfessor/" + response.data.id_proposta_proponente_professor, this.propostaProponenteProfessor)
                      .then(response => {});
                      } else {
                        axios.post("/api/propostaProponenteProfessor", this.propostaProponenteProfessor).then(response => {});
                      }
                    });

                    //? Update ficheiros
                    axios.get("/api/propostaDePropostaProponente/" + this.idParaUcsPropostaProponente).then(response => {
                      this.ficheiro.fileCurriculo.append("proposta_id", response.data.id);
                    
                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        this.ficheiro.fileHabilitacoes.append( "proposta_id", response.data.id);
                      }

                      this.ficheiro.fileRelatorio.append("proposta_id", response.data.id);

                      axios.delete("/api/deleteFicheiros/" + response.data.id).then(response => {});

                      axios.post("/api/ficheiro", this.ficheiro.fileRelatorio).then(response => {});
                    
                      axios.post("/api/ficheiro", this.ficheiro.fileCurriculo).then(response => {});

                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        axios.post("/api/ficheiro", this.ficheiro.fileHabilitacoes) .then(response => {});
                      }

                      this.$swal(
                                "Sucesso",
                                "Proposta editada com sucesso!!",
                                "success"
                              );
                              this.isLoading = false;
                              this.voltar();

                    })
                  });
              } else {
                this.isLoading = true;
                axios
                  .post("/api/propostaProponente", this.proposta)
                  .then(response => {
                    this.idParaUcsPropostaProponente = response.data.id_proposta_proponente;

                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      axios
                        .post("/api/ucsPropostaProponente", unidadeCurricular)
                        .then(response => {});

                      this.propostaProponenteProfessor.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    axios
                      .post(
                        "/api/propostaProponenteProfessor",
                        this.propostaProponenteProfessor
                      )
                      .then(response => {});

                    axios
                      .post("/api/proposta/" + this.idParaUcsPropostaProponente)
                      .then(response => {
                        this.ficheiro.fileCurriculo.append(
                          "proposta_id",
                          response.data
                        );

                        if (
                          this.proposta.tipo_contrato == "contratacao_inicial"
                        ) {
                          this.ficheiro.fileHabilitacoes.append(
                            "proposta_id",
                            response.data
                          );
                        }

                        this.ficheiro.fileRelatorio.append(
                          "proposta_id",
                          response.data
                        );

                        

                        axios
                          .post("/api/ficheiro", this.ficheiro.fileRelatorio)
                          .then(response => {});

                        axios
                          .post("/api/ficheiro", this.ficheiro.fileCurriculo)
                          .then(response => {});

                        if (
                          this.proposta.tipo_contrato == "contratacao_inicial"
                        ) {
                          axios
                            .post(
                              "/api/ficheiro",
                              this.ficheiro.fileHabilitacoes
                            )
                            .then(response => {
                              this.$swal(
                                "Sucesso",
                                "Proposta criada com sucesso!!",
                                "success"
                              );
                              this.isLoading = false;
                              this.voltar();
                            });
                        }
                      });
                  });
              }
            }
          });
        }
      }
    },
    submeterPropostaAssistente(propostaProponenteAssistente) {
      if (this.unidadesCurriculares.length > 0) {
         this.$v.$touch();
        if (!this.$v.$invalid) {
        this.$swal
          .fire({
            title: "Tem a certeza que pretende submeter estes dados?",
            text: "Não poderá realizar mais nenhuma alteração",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim",
            cancelButtonText: "Não"
          })
          .then(result => {
            if (result.value) {
              if (this.$store.state.editarProposta) {
                //? Update Proposta Proponente
                axios.put("/api/updatePropostaProponente/" + this.proposta.id_proposta_proponente, this.proposta)
                  .then(response => {
                    this.idParaUcsPropostaProponente = response.data.id_proposta_proponente;

                    //? Eliminar UCs Proponentes  Antigas
                    axios.get('api/getUcsPropostaProponente/' + this.proposta.id_proposta_proponente)
                    .then(response => {
                      response.data.forEach(unidadeCurricular => {
                        axios.delete("/api/ucsPropostaProponente/" + unidadeCurricular.id_ucs_proposta_proponente).then(response => {});
                      });
                    })

                    //? Criar UCs Proponentes Novas
                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      axios
                        .post("/api/ucsPropostaProponente", unidadeCurricular)
                        .then(response => {});

                      this.propostaProponenteAssistente.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    //? Apagar Propostas Proponente de todas as roles
                    axios.put('/api/apagarPropostasProponente/'+this.idParaUcsPropostaProponente, this.proposta).then(response => {});

                    //? Update Proposta Proponente Assistente
                    axios.get("/api/propostaProponenteAssistente/" + this.idParaUcsPropostaProponente).then(response => {
                      if(response.data.id_proposta_proponente_assistente) {
                        axios
                          .put("/api/updatePropostaProponenteAssistente/" + response.data.id_proposta_proponente_assistente, this.propostaProponenteAssistente)
                          .then(response => {});
                      } else {
                        axios.post("/api/propostaProponenteAssistente", this.propostaProponenteAssistente).then(response => {});
                      }
                    });

                    //? Update ficheiros
                    axios.get("/api/propostaDePropostaProponente/" + this.idParaUcsPropostaProponente).then(response => {
                      this.ficheiro.fileCurriculo.append("proposta_id", response.data.id);
                    
                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        this.ficheiro.fileHabilitacoes.append( "proposta_id", response.data.id);
                      }

                      this.ficheiro.fileRelatorio.append("proposta_id", response.data.id);

                      axios.delete("/api/deleteFicheiros/" + response.data.id).then(response => {});

                      axios.post("/api/ficheiro", this.ficheiro.fileRelatorio).then(response => {});
                    
                      axios.post("/api/ficheiro", this.ficheiro.fileCurriculo).then(response => {});

                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        axios.post("/api/ficheiro", this.ficheiro.fileHabilitacoes) .then(response => {});
                      }

                      this.$swal(
                                "Sucesso",
                                "Proposta editada com sucesso!!",
                                "success"
                              );
                              this.isLoading = false;
                              this.voltar();

                    })
                  });
              } else {
              axios
                .post("/api/propostaProponente", this.proposta)
                .then(response => {
                  this.idParaUcsPropostaProponente =
                    response.data.id_proposta_proponente;
                  this.unidadesCurriculares.forEach(unidadeCurricular => {
                    unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                  });
                  this.unidadesCurriculares.forEach(unidadeCurricular => {
                    axios
                      .post("/api/ucsPropostaProponente", unidadeCurricular)
                      .then(response => {});
                    this.propostaProponenteAssistente.proposta_proponente_id = this.idParaUcsPropostaProponente;
                  });
                  axios
                    .post(
                      "/api/propostaProponenteAssistente",
                      propostaProponenteAssistente
                    )
                    .then(response => {});

                  axios
                    .post("/api/proposta/" + this.idParaUcsPropostaProponente)
                    .then(response => {
                      this.ficheiro.fileCurriculo.append(
                        "proposta_id",
                        response.data
                      );
                      if (
                        this.proposta.tipo_contrato == "contratacao_inicial"
                      ) {
                        this.ficheiro.fileHabilitacoes.append(
                          "proposta_id",
                          response.data
                        );
                      }
                      this.ficheiro.fileRelatorio.append(
                        "proposta_id",
                        response.data
                      );

                      

                      axios
                        .post("/api/ficheiro", this.ficheiro.fileCurriculo)
                        .then(response => {});
                      axios
                        .post("/api/ficheiro", this.ficheiro.fileRelatorio)
                        .then(response => {});
                      if (
                        this.proposta.tipo_contrato == "contratacao_inicial"
                      ) {
                        axios
                          .post("/api/ficheiro", this.ficheiro.fileHabilitacoes)
                          .then(response => {
                            this.$swal(
                              "Sucesso",
                              "Proposta criada com sucesso!!",
                              "success"
                            );
                            this.isLoading = false;
                            this.voltar();
                          });
                      }
                    });
                });
            }
          }
          });
        }
      }
    },
    submeterPropostaMonitor(propostaProponenteMonitor) {
      if (this.unidadesCurriculares.length > 0) {
        this.$v.$touch();
        if (!this.$v.$invalid) {
        this.$swal
          .fire({
            title: "Tem a certeza que pretende submeter estes dados?",
            text: "Não poderá realizar mais nenhuma alteração",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Sim",
            cancelButtonText: "Não"
          })
          .then(result => {
            if (result.value) {
              if (this.$store.state.editarProposta) {
                //? Update Proposta Proponente
                axios.put("/api/updatePropostaProponente/" + this.proposta.id_proposta_proponente, this.proposta)
                  .then(response => {
                    this.idParaUcsPropostaProponente = response.data.id_proposta_proponente;

                    //? Eliminar UCs Proponentes  Antigas
                    axios.get('api/getUcsPropostaProponente/' + this.proposta.id_proposta_proponente)
                    .then(response => {
                      response.data.forEach(unidadeCurricular => {
                        axios.delete("/api/ucsPropostaProponente/" + unidadeCurricular.id_ucs_proposta_proponente).then(response => {});
                      });
                    })

                    //? Criar UCs Proponentes Novas
                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    this.unidadesCurriculares.forEach(unidadeCurricular => {
                      axios
                        .post("/api/ucsPropostaProponente", unidadeCurricular)
                        .then(response => {});

                      this.propostaProponenteMonitor.proposta_proponente_id = this.idParaUcsPropostaProponente;
                    });

                    //? Apagar Propostas Proponente de todas as roles
                    axios.put('/api/apagarPropostasProponente/'+this.idParaUcsPropostaProponente, this.proposta).then(response => {});

                    //? Update Proposta Proponente Monitor
                    axios.get("/api/propostaProponenteMonitor/" + this.idParaUcsPropostaProponente).then(response => {
                      if(response.data.id_proposta_proponente_monitor) {
                        axios
                          .put("/api/updatePropostaProponenteMonitor/" + response.data.id_proposta_proponente_monitor, this.propostaProponenteMonitor)
                          .then(response => {});
                      } else {
                        axios.post("/api/propostaProponenteMonitor", this.propostaProponenteMonitor).then(response => {});
                      }
                    });

                    //? Update ficheiros
                    axios.get("/api/propostaDePropostaProponente/" + this.idParaUcsPropostaProponente).then(response => {
                      this.ficheiro.fileCurriculo.append("proposta_id", response.data.id);
                    
                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        this.ficheiro.fileHabilitacoes.append( "proposta_id", response.data.id);
                      }

                      this.ficheiro.fileRelatorio.append("proposta_id", response.data.id);

                      axios.delete("/api/deleteFicheiros/" + response.data.id).then(response => {});

                      axios.post("/api/ficheiro", this.ficheiro.fileRelatorio).then(response => {});
                    
                      axios.post("/api/ficheiro", this.ficheiro.fileCurriculo).then(response => {});

                      if (this.proposta.tipo_contrato == "contratacao_inicial") {
                        axios.post("/api/ficheiro", this.ficheiro.fileHabilitacoes) .then(response => {});
                      }

                      this.$swal(
                                "Sucesso",
                                "Proposta editada com sucesso!!",
                                "success"
                              );
                              this.isLoading = false;
                              this.voltar();

                    })
                  });
              } else {
              this.isLoading = true;
              axios
                .post("/api/propostaProponente", this.proposta)
                .then(response => {
                  this.idParaUcsPropostaProponente =
                    response.data.id_proposta_proponente;
                  this.unidadesCurriculares.forEach(unidadeCurricular => {
                    unidadeCurricular.proposta_proponente_id = this.idParaUcsPropostaProponente;
                  });
                  this.unidadesCurriculares.forEach(unidadeCurricular => {
                    axios
                      .post("/api/ucsPropostaProponente", unidadeCurricular)
                      .then(response => {});
                    this.propostaProponenteMonitor.proposta_proponente_id = this.idParaUcsPropostaProponente;
                  });
                  axios
                    .post(
                      "/api/propostaProponenteMonitor",
                      propostaProponenteMonitor
                    )
                    .then(response => {});

                  axios
                    .post("/api/proposta/" + this.idParaUcsPropostaProponente)
                    .then(response => {
                      this.ficheiro.fileCurriculo.append(
                        "proposta_id",
                        response.data
                      );
                      if (
                        this.proposta.tipo_contrato == "contratacao_inicial"
                      ) {
                        this.ficheiro.fileHabilitacoes.append(
                          "proposta_id",
                          response.data
                        );
                      }
                      this.ficheiro.fileRelatorio.append(
                        "proposta_id",
                        response.data
                      );

                      

                      axios
                        .post("/api/ficheiro", this.ficheiro.fileRelatorio)
                        .then(response => {});

                      axios
                        .post("/api/ficheiro", this.ficheiro.fileCurriculo)
                        .then(response => {});
                      if (
                        this.proposta.tipo_contrato == "contratacao_inicial"
                      ) {
                        axios
                          .post("/api/ficheiro", this.ficheiro.fileHabilitacoes)
                          .then(response => {
                            this.$swal(
                              "Sucesso",
                              "Proposta criada com sucesso!!",
                              "success"
                            );
                            this.isLoading = false;
                            this.voltar();
                          });
                      }
                    });
                });
            }
            }
          });
        }
      }
    },
    makeToast(variant = null) {
      this.$bvToast.toast("", {
        title: `O Diretor da ${this.proposta.unidade_organica} foi notificado via email!`,
        variant: variant,
        solid: true,
        toaster: "b-toaster-top-right"
      });
    },
    anterior() {
      //* Mudar para o componente PropostaProponente*
      this.$emit("mostrarPropostaProponente_" + this.proposta.role);
    }
  },

};
</script>