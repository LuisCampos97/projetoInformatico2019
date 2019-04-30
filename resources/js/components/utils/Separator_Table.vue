<template>
  <div class="main">
    <!-- <button class=" btn btn-success mb-4 font-weight-bold" v-on:click.prevent="novaProposta">
      <i class="fas fa-plus"></i> Nova Proposta
    </button> -->
    <div class="separator">
      <b-tabs content-class="mt-3" align="left">
        <b-tab title="Propostas Pendentes" active>
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Last</th>
                <th scope="col">Handle</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>Mark</td>
                <td>Otto</td>
                <td>@mdo</td>
              </tr>
              <tr>
                <th scope="row">2</th>
                <td>Jacob</td>
                <td>Thornton</td>
                <td>@fat</td>
              </tr>
              <tr>
                <th scope="row">3</th>
                <td>Larry</td>
                <td>the Bird</td>
                <td>@twitter</td>
              </tr>
            </tbody>
          </table>
        </b-tab>
        <b-tab title="Histórico de Propostas">
          <b-table :items="items" :fields="fields" :head-variant="header"></b-table>
        </b-tab>
      </b-tabs>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      header: "dark",
      fields: ["first_name", "last_name", "age"],
      items: [
        {
          isActive: true,
          age: 40,
          first_name: "Dickerson",
          last_name: "Macdonald"
        },
        { isActive: false, age: 21, first_name: "Larsen", last_name: "Shaw" },
        { isActive: false, age: 89, first_name: "Geneva", last_name: "Wilson" },
        { isActive: true, age: 38, first_name: "Jami", last_name: "Carney" }
      ]
    };
  },
  methods: {
    getPropostasPendeste() {

    },
    getHisstoricoPropostas() {
      //? Propostas Aceites e Recusadas
    }
  }
};
</script>

<style lang="scss" scoped>
.main {
  font-size: 20px;
  font-family: 'Montserrat', sans-serif;
}
</style>
