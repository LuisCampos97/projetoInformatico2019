<template>
  <div>
    <h2>Proponente (Professor)</h2>
    <br>
    <h5>Qual será o role_professor específico do professor a ser contratado?</h5>
    <br>
    <div id="radio_role_professor" class="radio">
      <input type="radio" v-model="propostaProponenteProfessor.role_professor" value="Coordenador"> Coordenador
      <br>
      <input type="radio" v-model="propostaProponenteProfessor.role_professor" value="Adjunto"> Adjunto
      <br>
      <input type="radio" v-model="propostaProponenteProfessor.role_professor" value="Visitante"> Visitante
    </div>
    <br>
    <div>
      <h5>Regime de prestação de serviços:</h5>
      <br>
      <div id="radio_regime" class="radio">
        <input
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Tempo Integral"
        > Tempo Integral
        <br>
        <input
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Tempo Parcial"
        > Tempo Parcial
        <br>
        <input
          type="radio"
          v-model="propostaProponenteProfessor.regime_prestacao_servicos"
          value="Dedicação Exclusiva"
        > Dedicação Exclusiva
        <br>
      </div>
    </div>
    <br>
    <span v-if="propostaProponenteProfessor.regime_prestacao_servicos == 'Tempo Parcial'">
      <h5>Percentagem de tempo parcial:</h5>
      <br>
      <input
        type="number"
        class="form-control"
        placeholder="Insira um valor entre 1 e 100"
        v-model="propostaProponenteProfessor.percentagem_prestacao_servicos"
      >
    </span>
    <br>
    <div>
      <h5>Duração do contrato (em meses)</h5>
      <br>
      <input
        type="text"
        class="form-control"
        placeholder="Insira um valor positivo e inteiro"
        v-model="propostaProponenteProfessor.duracao"
      >
    </div>
    <br>
    <div>
      <h5>Data de inicio do contrato</h5>
      <br>
      <input
        type="date"
        class="form-control"
        placeholder="Selecione a data de inicio de contrato"
        v-model="propostaProponenteProfessor.data_inicio_contrato"
        @change="setDataFimContrato(propostaProponenteProfessor.duracao)"
      >
    </div>
    <br>
    <div>
      <h5>Data de fim do contrato</h5>
      <br>
      <input type="text" class="form-control" v-model="dataFimContratoText" readonly>
      <br>
    </div>
    <br>
    <button
      type="button"
      class="btn btn-success"
      v-on:click="criarPropostaProponenteProfessor(propostaProponenteProfessor)"
    >Finalizar e criar proposta</button>
  </div>
</template>
<script>
module.exports = {
  props: ["idParaUcsPropostaProponente"],
  data() {
    return {
      propostaProponenteProfessor: {
        role_professor: "",
        regime_prestacao_servicos: "",
        percentagem_prestacao_servicos: "",
        duracao: "",
        data_inicio_contrato: "",
        data_fim_contrato: "",
        proposta_proponente_id: ""
      },
      dataFimContratoText: ""
    };
  },
  methods: {
    setDataFimContrato(duracao) {
      this.propostaProponenteProfessor.proposta_proponente_id = this.idParaUcsPropostaProponente;
      var array = this.propostaProponenteProfessor.data_inicio_contrato.split(
        "-"
      );
      console.log(array[2], array[1], array[0]);
      let data = new Date(
        parseInt(array[0]),
        parseInt(array[1]) - 1,
        parseInt(array[2])
      );
      data.setMonth(data.getUTCMonth() + parseInt(duracao));
      let dia = data.getDate();
      let mes = data.getMonth() + 1;
      let ano = data.getFullYear();
      this.dataFimContratoText = dia + "/" + mes + "/" + ano;
      this.propostaProponenteProfessor.data_fim_contrato = new Date(data)
        .toISOString()
        .slice(0, 19)
        .replace("T", " ");
      console.log(this.propostaProponenteProfessor.data_fim_contrato);
    },
    criarPropostaProponenteProfessor(propostaProponenteProfessor) {
      if (
        this.propostaProponenteProfessor.role_professor == "" ||
        this.propostaProponenteProfessor.regime_prestacao_servicos == "" ||
        this.propostaProponenteProfessor.duracao == "" ||
        this.propostaProponenteProfessor.data_inicio_contrato == "" ||
        this.propostaProponenteProfessor.data_fim_contrato == "" ||
        this.propostaProponenteProfessor.proposta_proponente_id == ""
      ) {
        console.log("ERROR!!! Validar ainda nas caixas correspondentes");
      } else {
        axios
          .post("/api/propostaProponenteProfessor", propostaProponenteProfessor)
          .then(response => {});
      }
    }
  }
};
</script>