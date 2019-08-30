<template>
  <div>
    <h3>Número de Propostas: <b>{{numeroPropostas}}</b></h3>
    <br>
    <div v-if="numeroPropostas > 0">
    <h3>Propostas por papel de docente atribuido</h3>
    <div id="chart">
      <apexchart type=donut width=380 :options="chartOptions" :series="series" />
    </div>
    <br>
    <h3>Propostas por tipo de contrato</h3>
    <div id="chart">
      <apexchart type=donut width=380 :options="chartOptionsTipoContrato" :series="seriesTipoContrato" />
    </div>
    <br><br>
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
        series: [],
        labels: ["Professor", "Assistente", "Monitor"],
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
      seriesTipoContrato: [],
      chartOptionsTipoContrato: {
        labels: ["Contratação Inicial", "Renovação", "Alteração"],
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
    axios.get('/api/getPropostasPorTipoDeDocente/'+this.$store.state.user.id).then(response => {
      this.series = response.data;
    });

    axios.get('/api/getPropostasPorTipoDeContrato/'+this.$store.state.user.id).then(response => {
      this.seriesTipoContrato = response.data;
    });

    axios.get('/api/getPropostasProponente/'+this.$store.state.user.id).then(response => {
      this.numeroPropostas = response.data.length;
    });
  }
}
</script>