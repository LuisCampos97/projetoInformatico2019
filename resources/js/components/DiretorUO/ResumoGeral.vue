<template>
  <div>
    <h3>Resumo da proposta de contratação</h3>
    <button v-if="this.$store.state.user.roleDB == 'diretor_uo'" class="btn btn-danger" @click="voltar">Voltar</button>
    <button v-if="this.$store.state.user.roleDB == 'ctc'" class="btn btn-danger" @click="voltarCTC">Voltar</button>
    <button v-if="this.$store.state.user.roleDB == 'secretariado_direcao'" class="btn btn-danger" @click="voltarSecretariado">Voltar</button>

    <b-form-group label="Unidade Orgânica">
      <b-form-input :readonly="true" v-model="propostaSelecionada.unidade_organica"></b-form-input>
    </b-form-group>
    <b-form-group label="Nome do docente">
      <b-form-input :readonly="true" v-model="propostaSelecionada.nome_completo"></b-form-input>
    </b-form-group>
    <b-form-group label="Tipo de Contratação">
      <b-form-input :readonly="true" v-model="propostaSelecionada.tipo_contrato"></b-form-input>
    </b-form-group>
    <b-form-group label="Unidades Curriculares">
      <table class="table mt-3">
        <thead>
          <th>Codigo UC</th>
          <th>Turno</th>
          <th>Regime</th>
          <th>Horas</th>
          <th>Horas Semestrais</th>
          <th>Tipo</th>
        </thead>
        <tbody>
          <tr v-for="uc in ucsDaPropostaSelecionada" :key="uc.ID">
            <td>{{ uc.codigo_uc }}</td>
            <td>{{ uc.turno }}</td>
            <td>{{ uc.regime }}</td>
            <td>{{ uc.horas }}</td>
            <td>{{ uc.horas_semestrais }}</td>
            <td>{{ uc.tipo }}</td>
          </tr>
        </tbody>
      </table>
    </b-form-group>
    <b-form-group label="Grau de Habilitações Académicas">
      <b-form-input :readonly="true" v-model="propostaSelecionada.grau"></b-form-input>
    </b-form-group>
    <b-form-group label="Área Científica">
      <b-form-input :readonly="true" v-model="propostaSelecionada.area_cientifica"></b-form-input>
    </b-form-group>
    <b-form-group label="Curso">
      <b-form-input :readonly="true" v-model="propostaSelecionada.curso"></b-form-input>
    </b-form-group>
    <b-form-group label="Papel a desempenhar">
      <b-form-input :readonly="true" v-model="propostaSelecionada.role"></b-form-input>
    </b-form-group>
    <b-form-group v-if="propostaSelecionada.role == 'professor'" label="Categoria de professor">
      <b-form-input :readonly="true" v-model="tipoPropostaRole.role_professor"></b-form-input>
    </b-form-group>
    <b-form-group label="Regime de Prestação de Serviços">
      <b-form-input :readonly="true" v-model="tipoPropostaRole.regime_prestacao_servicos"></b-form-input>
    </b-form-group>
    <b-form-group label="Percentagem Prestação Serviços">
      <b-form-input :readonly="true" v-model="tipoPropostaRole.percentagem_prestacao_servicos"></b-form-input>
    </b-form-group>
    <b-form-group label="Período">
      <b-form-input :readonly="true" v-model="tipoPropostaRole.periodo"></b-form-input>
    </b-form-group>
    <b-form-group label="Duração">
      <b-form-input :readonly="true" v-model="tipoPropostaRole.duracao"></b-form-input>
    </b-form-group>
    <b-form-group label="Fundamentação Coordenador de Curso">
      <b-form-input :readonly="true" v-model="propostaSelecionada.fundamentacao_coordenador_curso"></b-form-input>
    </b-form-group>
    <b-form-group label="Fundamentação Coordenador de Departamento">
      <b-form-input :readonly="true" v-model="propostaSelecionada.fundamentacao_coordenador_departamento"></b-form-input>
    </b-form-group>
    <div v-if="this.$store.state.user != 'proponente' ">
    <b-form-group label="Parecer sobre a proposta do Diretor da Unidade Orgânica">
      <b-form-input :readonly="true" v-model="propostaSelecionada.parecer"></b-form-input>
    </b-form-group>
    </div>
    <div v-if="this.$store.state.user != 'proponente' || this.$store.state.user != 'diretor_uo'">
    <b-form-group label="Votos a favor do Conselho Tecnico-Científico">
      <b-form-input :readonly="true" v-model="propostaSelecionada.votos_a_favor"></b-form-input>
    </b-form-group>
    <b-form-group label="Votos contra do Conselho Tecnico-Científico">
      <b-form-input :readonly="true" v-model="propostaSelecionada.votos_contra"></b-form-input>
    </b-form-group>
    <b-form-group label="Votos brancos do Conselho Tecnico-Científico">
      <b-form-input :readonly="true" v-model="propostaSelecionada.votos_brancos"></b-form-input>
    </b-form-group>
    <b-form-group label="Votos nulos do Conselho Tecnico-Científico">
      <b-form-input :readonly="true" v-model="propostaSelecionada.votos_nulos"></b-form-input>
    </b-form-group>
    </div>

    <diretor v-if="propostaSelecionada.proposta_diretor_uo_id == null && this.$store.state.user.roleDB == 'diretor_uo'"
     :propostaSelecionada="propostaSelecionada"></diretor>
    <ctc v-if="propostaSelecionada.proposta_ctc_id == null && this.$store.state.user.roleDB == 'ctc'"
     :propostaSelecionada="propostaSelecionada"></ctc>
    <proposta-secretariado v-if="this.$store.state.user.roleDB == 'secretariado_direcao'"></proposta-secretariado>
  </div>
  
</template>
<script>
export default {
  props: ["propostaSelecionada"],
  data() {
    return {
      tipoPropostaRole: [],
      ucsDaPropostaSelecionada: [],
    };
  },
  methods: {
   voltar(){
     this.$emit('mostrar-diretor');
   },
   voltarCTC(){
     this.$emit('mostrar-ctc');
   },
   voltarSecretariado(){
     this.$emit('mostrar-secretariado');
   }
  },
  mounted() {
    axios
      .get(
        "/api/diretorUO/getPropostaProponente/" +
          this.propostaSelecionada.role +
          "/" +
          this.propostaSelecionada.proposta_proponente_id
      )
      .then(response => {
        this.tipoPropostaRole = response.data;
      });
    axios
      .get(
        "api/diretorUO/getUCSPropostaSelecionada/" +
          this.propostaSelecionada.proposta_proponente_id
      )
      .then(response => {
        this.ucsDaPropostaSelecionada = response.data;
      });
  }
};
</script>