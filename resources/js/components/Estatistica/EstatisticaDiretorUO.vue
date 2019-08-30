<template>
  <div>
    <h3>Número de Propostas: <b>{{numeroPropostas}}</b></h3>
    <br>
    <div v-if="numeroPropostas > 0">
    <h3>Propostas pelo parecer atribuído</h3>
    <div id="chart">
      <apexchart type=donut width=380 :options="chartOptions" :series="series" />
    </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      numeroPropostas: 0,
      series: [],
      chartOptions: {
        labels: ["Favorável", "Desfavorável"],
       dataLabels: {
          enabled: false
        },
        fill: {
          type: 'gradient',
        },
        legend: {
          formatter: function (val, opts) {
            return val + " - " + opts.w.globals.series[opts.seriesIndex]
          }
        },
        responsive: [{
          breakpoint: 480,
          options: {
            chart: {
              width: 200
            },
            legend: {
              position: 'bottom'
            }
          }
        }]
    
      },
    }
  },
  mounted() {
    axios.get('api/diretorUO/getPropostas/'+this.$store.state.user.id).then(response => {
      this.numeroPropostas = response.data.length;
    });

    axios.get('api/diretorUO/getPropostasPorTipoParecer/'+this.$store.state.user.id).then(response => {
      this.series = response.data;
    });
  }
}
</script>