<template>
  <div class="main">
    <div class="separator">
      <b-tabs content-class="mt-3" align="right">
        <b-tab title="Propostas Pendentes" active></b-tab>
        <b-tab title="Histórico de Propostas">
          <b-table
            :head-variant="header"
            :items="items"
            :fields="fields"
            :tbody-tr-class="rowClass"
          ></b-table>
        </b-tab>
      </b-tabs>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    let a=[false,false,false]
    return {
      header: "dark",
      fields: ["nome_proponente", "estado", "data", "detalhes"],
      items: [
        {
          nome_proponente: "Luís Campos",
          estado: a[2] ? 'Aceite':'Recusada',
          data: "27/12/2019"
        },
                {
          nome_proponente: "António",
           estado:a[2] ? true:false,
          data: "27/12/2019"
        },
                {
          nome_proponente: "Luís",
          estado: false,
          data: "27/12/2019"
        },
      ]
    };
  },
  methods: {
    rowClass(item, type) {
      if (!item) return;
      if (item.estado === true) return "table-success" 
      else return "table-danger";
    }
  }
};
</script>

<style lang="scss" scoped>
@import "../../../sass/_variables.scss";

.main {
  margin: 40px;
  font-size: 20px;
}

.separator {
  font-weight: 600;
}
</style>
