<template>
    <div class="table-responsive m-0 p-0">
        <table
            class="table table-sm table-bordered table-hover m-0"
        >
            <thead class="thead-light">
                <tr class="row m-0">
                    <th class="col-2">Nr. Doc</th>
                    <th class="col-2">Série</th>
                    <th class="col-2">Data</th>
                    <th class="col-4">Tanque</th>
                    <th class="col-2">Qtd</th>
                </tr>
            </thead>
            <tbody name="fade" is="transition-group">
                <tr class="row m-0" v-for="(entrada, index) in entradas" :key="index">
                    <td class="col-2 pool-right">{{ entrada.nr_docto }}</td>
                    <td class="col-2 text-right">{{ entrada.serie }}</td>
                    <td class="col-2 text-right">{{ entrada.data }}</td>
                    <td
                        class="col-4 text-right"
                    >{{ entrada.descricao_tanque + ' - ' + entrada.descricao }}</td>
                    <td class="col-2 text-right">{{ entrada.quantidade }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>


<script>
import Axios from "axios";

export default {
    data() {
        return {
            entradas: []
        };
    },
    mounted() {
        Axios.get("dashboard/ultimas_entradas_comb")
            .then(r => {
                this.entradas = r.data;
            })
            .catch(e => {
                console.log(e);
            });
    }
};
</script>
