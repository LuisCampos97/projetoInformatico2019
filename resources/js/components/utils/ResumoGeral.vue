<template>
  <div>
    <div v-if="this.$store.state.user.roleDB == 'proponente_departamento'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarProponentes">Voltar</button>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'proponente_curso'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarProponentes">Voltar</button>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'diretor_uo'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarDiretor">Voltar</button>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'ctc'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarCTC">Voltar</button>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'secretariado_direcao'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarSecretariado">Voltar</button>
    </div>

    <div v-if="this.$store.state.user.roleDB == 'recursos_humanos'">
      <h3>Resumo da proposta de contratação</h3>
      <button class="btn btn-danger" @click="voltarRecursosHumanos">Voltar</button>
    </div>

    <b-form-group label="Unidade Orgânica">
      <b-form-input :readonly="true" v-model="propostaSelecionada.unidade_organica"></b-form-input>
    </b-form-group>
    <b-form-group label="Nome do docente">
      <b-form-input :readonly="true" v-model="propostaSelecionada.nome_completo"></b-form-input>
    </b-form-group>
    <b-form-group label="Tipo de Contratação">
      <b-form-input :readonly="true" v-model="propostaSelecionada.tipo_contrato"></b-form-input>
    </b-form-group>
    <b-form-group label="Email">
      <b-form-input :readonly="true" v-model="propostaSelecionada.email"></b-form-input>
    </b-form-group>
    <b-form-group label="Número telefone">
      <b-form-input :readonly="true" v-model="propostaSelecionada.numero_telefone"></b-form-input>
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
      <b-form-input
        :readonly="true"
        v-model="propostaSelecionada.fundamentacao_coordenador_departamento"
      ></b-form-input>
    </b-form-group>

    <div
      v-if="propostaSelecionada.proposta_diretor_uo_id != null &&(this.$store.state.user.roleDB == 'diretor_uo' 
    || this.$store.state.user.roleDB == 'ctc' || this.$store.state.user.roleDB == 'secretariado_direcao' || 
    this.$store.state.user.roleDB == 'recursos_humanos' )"
    >
      <b-form-group label="Parecer sobre a proposta do Diretor da Unidade Orgânica">
        <b-form-input :readonly="true" v-model="propostaSelecionada.parecer"></b-form-input>
      </b-form-group>
    </div>
    <div
      v-if="propostaSelecionada.proposta_ctc_id != null &&
        (this.$store.state.user == 'ctc'
        || this.$store.state.user.roleDB == 'secretariado_direcao' 
        || this.$store.state.user.roleDB == 'recursos_humanos')"
    >
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
    <!--
    <div v-if="propostaSelecionada.proposta_ctc_id != null &&(
      this.$store.state.user.roleDB == 'secretariado_direcao' || 
      this.$store.state.user.roleDB == 'recursos_humanos')">
      <b-form-group label="Convite" >
        <b-form-textarea
        :readonly="true"
          v-model="propostaSelecionada.convite"
        ></b-form-textarea>
        <b-form-invalid-feedback id="input-1-live-feedback">A fundamentação é obrigatória!</b-form-invalid-feedback>
      </b-form-group>
    </div>
    -->
    <div
      v-if="propostaSelecionada.proposta_recursos_humanos_id != null &&
      this.$store.state.user.roleDB == 'recursos_humanos'"
    >
      <b-form-group label="Remuneração">
        <b-form-input :readonly="true" v-model="propostaSelecionada.remuneracao"></b-form-input>
      </b-form-group>
      <b-form-group label="Indice">
        <b-form-input :readonly="true" v-model="propostaSelecionada.indice"></b-form-input>
      </b-form-group>
      <b-form-group label="Escalao">
        <b-form-input :readonly="true" v-model="propostaSelecionada.escalao"></b-form-input>
      </b-form-group>
      <b-form-group label="Numero Funcionário">
        <b-form-input :readonly="true" v-model="propostaSelecionada.numero_funcionario"></b-form-input>
      </b-form-group>
      <b-form-group label="Inscrição">
        <b-form-input :readonly="true" v-model="propostaSelecionada.inscricao"></b-form-input>
      </b-form-group>
      <b-form-group label="Despacho Presidente IPL">
        <b-form-input :readonly="true" v-model="propostaSelecionada.despacho_presidente_ipl"></b-form-input>
      </b-form-group>
      <b-form-group label="NISS ou nº CGA">
        <b-form-input :readonly="true" v-model="propostaSelecionada.NISS_ou_numero_CGA"></b-form-input>
      </b-form-group>
      <b-form-group label="Data Nascimento">
        <b-form-input :readonly="true" v-model="propostaSelecionada.data_nascimento"></b-form-input>
      </b-form-group>
      <b-form-group label="Número Cartão Cidadão">
        <b-form-input :readonly="true" v-model="propostaSelecionada.numero_CC"></b-form-input>
      </b-form-group>
      <b-form-group label="Email RH">
        <b-form-input :readonly="true" v-model="propostaSelecionada.email_recursos_humanos"></b-form-input>
      </b-form-group>
      <b-form-group label="Dados GIAF carregados por">
        <b-form-input :readonly="true" v-model="propostaSelecionada.dados_GIAF_carregados_por"></b-form-input>
      </b-form-group>
      <b-form-group label="Data de carregamento de dados no GIAF">
        <b-form-input :readonly="true" v-model="propostaSelecionada.data_carregamento_dados_GIAF"></b-form-input>
      </b-form-group>
    </div>
    <fundamentacao-departamento
      v-if="this.$store.state.user.roleDB == 'proponente_departamento' &&
      this.propostaSelecionada.fundamentacao_coordenador_departamento == null"
      :propostaSelecionada="propostaSelecionada"
    ></fundamentacao-departamento>

    <fundamentacao-curso
      v-if="this.$store.state.user.roleDB == 'proponente_curso' &&
            this.propostaSelecionada.fundamentacao_coordenador_curso == null"
      :propostaSelecionada="propostaSelecionada"
    ></fundamentacao-curso>

    <diretor
      v-if="this.$store.state.user.roleDB == 'diretor_uo' && this.propostaSelecionada.proposta_diretor_uo_id == null"
      :propostaSelecionada="propostaSelecionada"
    ></diretor>
    <ctc
      v-if="propostaSelecionada.proposta_ctc_id == null && this.$store.state.user.roleDB == 'ctc'"
      :propostaSelecionada="propostaSelecionada"
    ></ctc>
    <proposta-secretariado
      v-if="propostaSelecionada.proposta_secretariado_direcao_id == null &&this.$store.state.user.roleDB == 'secretariado_direcao'"
      :propostaSelecionada="propostaSelecionada"
    ></proposta-secretariado>
    <proposta-recursos
      v-if="propostaSelecionada.proposta_recursos_humanos_id == null && this.$store.state.user.roleDB == 'recursos_humanos'"
      :propostaSelecionada="propostaSelecionada"
    ></proposta-recursos>
  </div>
</template>
<script>
export default {
  props: ["propostaSelecionada"],
  data() {
    return {
      tipoPropostaRole: [],
      ucsDaPropostaSelecionada: [],
      ficheiros: [],
    };
  },
  methods: {
    voltarProponentes() {
      this.$emit("mostrar-proponentes");
    },
    voltarDiretor() {
      this.$emit("mostrar-diretor");
    },
    voltarCTC() {
      this.$emit("mostrar-ctc");
    },
    voltarSecretariado() {
      this.$emit("mostrar-secretariado");
    },
    voltarRecursosHumanos() {
      this.$emit("mostrar-recursos");
    }
  },
  mounted() {
    axios
      .get(
        "/api/diretorUO/getPropostaProponente/" +
          this.propostaSelecionada.role +
          "/" +
          this.propostaSelecionada.id_proposta_proponente
      )
      .then(response => {
        this.tipoPropostaRole = response.data;
      });

    axios
      .get(
        "api/diretorUO/getUCSPropostaSelecionada/" +
          this.propostaSelecionada.id_proposta_proponente
      )
      .then(response => {
        this.ucsDaPropostaSelecionada = response.data;
      });
  }
};
</script>