<template>
<div>
  <h3>Número de Propostas: <b>{{numeroPropostas}}</b></h3>
</div>
</template>

<script>
export default {
  data() {
    return {
      numeroPropostas: 0,
    }
  },
  mounted() {
    axios.get('api/recursosHumanos/getPropostas/'+this.$store.state.user.id).then(response => {
      this.numeroPropostas = response.data.length;
    });
  }
}
</script>