<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">Parecer sobre esta proposta</div>
            <div class="card-body">
              <h6>Reconhecimento</h6>
              <div class="checkbox">
                <label>
                  <input
                    type="checkbox"
                    name="Reconhecimento"
                    v-model="propostaDiretor.reconhecimento"
                    v-validate="'required'"
                  >Reconheço a necessidade de criação/renovação desta proposta
                </label>
              </div>
              <br>
              <div>
                <h6>Parecer:</h6>
                <input
                  name="Parecer"
                  type="radio"
                  v-model="propostaDiretor.parecer"
                  value="Favoravel"
                  @change="showValue"
                > Favorável
                <br>
                <input
                  name="Parecer"
                  type="radio"
                  v-model="propostaDiretor.parecer"
                  value="Desfavoravel"
                  @change="showValue"
                > Desfavorável
                <br>
              </div>
            </div>
            <br>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
module.exports = {
  data() {
    return {
      propostaDiretor: {
        reconhecimento: "",
        parecer: []
      }
    };
  },
  methods: {
    showValue() {
      console.log(this.propostaDiretor.parecer);
    }
  }
};
</script>