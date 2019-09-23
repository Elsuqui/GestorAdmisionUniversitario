<script>
    import { Pie, mixins } from "vue-chartjs";
    export default {
        name: "PieChart",
        mixins: [Pie, mixins.reactiveProp],
        props:['chartData','options'],
        mounted(){
            console.log("Chardata", this.chartData);
            this.renderChart(this.chartData, this.options);
        },
        watch:{
            chartData(){
                this.$data._chart.update()
            }
        }
    }
</script>

<style scoped>

</style>
