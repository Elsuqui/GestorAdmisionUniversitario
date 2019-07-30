<script>
    import { HorizontalBar, mixins } from "vue-chartjs";
    export default {
        name: "BarChart",
        mixins: [HorizontalBar, mixins.reactiveProp],
        props:['chartData','options'],
        mounted(){
            this.renderChart(this.chartData, this.options);
        },
    }
</script>

<style scoped>

</style>
