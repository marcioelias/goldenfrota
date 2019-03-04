<template>
	<div class="table-responsive m-0 p-0">
		<table class="table table-sm table-bordered table-hover m-0">
			<thead class="thead-light">
				<tr class="row m-0">
					<th class="col-2">OS</th>
					<th class="col-3">Veículo</th>
					<th class="col-3">Usuário</th>
					<th class="col-3">Dias em aberto</th>
					<th class="col-1"></th>
				</tr>
			</thead>
			<tbody name="fade" is="transition-group">
				<tr class="row m-0" v-for="(os, index) in oss" :key="index">
					<td class="col-2 pool-right">{{ os.id }}</td>
					<td class="col-3 text-right">{{ os.veiculo }}</td>
					<td class="col-3 text-right">{{ os.usuario }}</td>
					<td class="col-3 text-right">{{ os.dias_em_aberto }}</td>
					<td class="col-1 text-right">
						<a :href="'/ordem_servico/'+os.id+'/edit'" class="btn btn-sm btn-warning">
							<i class="fas fa-edit"></i>
						</a>
					</td>
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
			oss: []
		};
	},
	mounted() {
		Axios.get("dashboard/os_em_aberto")
			.then(r => {
				this.oss = r.data;
			})
			.catch(e => {
				console.log(e);
			});
	}
};
</script>
