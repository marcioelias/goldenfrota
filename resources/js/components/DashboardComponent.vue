<template>
    <div class="container-fluid mt-3">
      <div class="row">
        <div class="col-md-6">
          <div class="card bg-light text-dark">
            <div class="card-header">Movimentação de Combustíveis (Últimos 15 dias) </div>
            <div class="card-body">
              <mov-tanque></mov-tanque>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import MovTanque from "./dashboard/MovTanque.vue";

export default {
    components: {
        "mov-tanque": MovTanque
    }
};
</script>
