<template>
    <div>
    <b-form-group label="Código de Curso" label-for="inputCodigoCurso">
      <b-form-input
        id="inputCodigoCurso"
        :state="$v.curso.codigo.$dirty ? !$v.curso.codigo.$error : null"
        v-model="curso.codigo"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Código de curso obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <b-form-group label="Nome do Curso" label-for="inputNomeCurso">
      <b-form-input
        id="inputNomeCurso"
        :state="$v.curso.nome_curso.$dirty ? !$v.curso.nome_curso.$error : null"
        v-model="curso.nome_curso"
      ></b-form-input>
      <b-form-invalid-feedback id="input-1-live-feedback">Nome de curso obrigatorio</b-form-invalid-feedback>
    </b-form-group>

    <button
      class="btn btn-success mt-3 font-weight-bold"
      v-on:click.prevent="criarCurso(curso)"
    >
      Submeter
      <i class="fas fa-arrow-right"></i>
          </button>


    </div>
</template>
<script>
import { required } from "vuelidate/lib/validators";

export default {
    data() {
        return {
            curso:{
                codigo:"",
                nome_curso:"",
            }
        }
    },
    validations:{
        curso :{
            codigo:{ required },
            nome_curso: { required },
        }
    },
    methods: {
        criarCurso(curso){
            axios.post('/api/criarCurso', this.curso).then(response => {
                this.$swal('Sucesso', 'Curso criado com sucesso', 'success')
                this.$emit('fecharCurso');

            })
            .catch(error => {
                this.$swal('Erro', 'Já existe um curso com esse nome ou código', 'error')
            })
        }
    },
}
</script>