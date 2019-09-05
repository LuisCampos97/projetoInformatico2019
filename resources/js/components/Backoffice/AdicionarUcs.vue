<template>
    <div>

    <b-form-group label="Curso" label-for="inputCurso">
        <b-form-select
            id="inputCurso"
            v-model="unidadeCurricular.codigo_curso"
            :state="!$v.unidadeCurricular.codigo_curso.$error && null"
            :options="cursos"
        ></b-form-select>
        <b-form-invalid-feedback id="input-1-live-feedback">O Curso é obrigatório!</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Nome da Unidade Curricular" label-for="inputNomeUC">
      <b-form-input
        id="inputNomeUC"
        :state="$v.unidadeCurricular.nome.$dirty ? !$v.unidadeCurricular.nome.$error : null"
        v-model="unidadeCurricular.nome"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Nome de UC obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Codigo da UC" label-for="inputCodigoUC">
      <b-form-input
        id="inputCodigoUC"
        :state="$v.unidadeCurricular.codigo.$dirty ? !$v.unidadeCurricular.codigo.$error : null"
        v-model="unidadeCurricular.codigo"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Codigo de UC obrigatorio</b-form-invalid-feedback>
    </b-form-group>

     <button class="btn btn-success mt-3 font-weight-bold" v-on:click.prevent="criarUC(unidadeCurricular)">Submeter
      <i class="fas fa-arrow-right"></i></button>

    </div>
</template>

<script>
import { required } from "vuelidate/lib/validators";

export default {
    data() {
        return {
            unidadeCurricular:{
                codigo:"",
                nome:"",
                codigo_curso:"",
            },
            cursos:[]
        }
    },
    validations:{
        unidadeCurricular:{
            codigo: { required },
            nome:{ required },
            codigo_curso:{ required },
        }
    },
    methods:{
        criarUC(unidadeCurricular){
            axios.post('/api/criarUC', unidadeCurricular).then(response => {
                this.$swal('Sucesso', 'UC criada com sucesso', 'success')
                this.$emit('fecharUcs');
            })
            .catch(error => {
                this.$swal('Erro', 'Já existe uma UC com esse nome ou código', 'error')
            });
        }
    },
    mounted(){
        axios.get("/api/cursosDisponiveis").then(response => {
            response.data.forEach(curso => {
                this.cursos.push({
                value: curso.codigo,
                text: curso.nome_curso
                });
            });
        });
    }
}
</script>