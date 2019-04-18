<template>
  <div>
      <div>
      <button type="button" class="btn btn-outline-danger" v-on:click.prevent="goBack">Voltar</button>
      </div>
      <div>
        
      </div>
  </div>
</template>
<script>
module.exports = {
  data() {
    return {};
  },
  methods: {
      goBack() {
        this.$router.go(-1);
      },
  }
};
</script>