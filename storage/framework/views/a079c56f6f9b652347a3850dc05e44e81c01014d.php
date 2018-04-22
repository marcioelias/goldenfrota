<?php
    $abast_local = isset($_GET['abast_local']) ? $_GET['abast_local'] : -1;
    $data_inicial = isset($_GET['data_inicial']) ? $_GET['data_inicial'] : null;
    $data_final = isset($_GET['data_final']) ? $_GET['data_final'] : null;
?>
<?php $__env->startComponent('components.input-datetime', [
    'id' => 'data_inicial',
    'name' => 'data_inicial',
    'field' => 'data_inicial',
    'label' => 'Data Inicial',
    'inputSize' => 4,
    'dateTimeFormat' => 'DD/MM/YYYY',
    'picker_begin' => 'data_inicial',
    'picker_end' => 'data_final',
    'inputValue' => $data_inicial
]); ?>
<?php echo $__env->renderComponent(); ?>
<?php $__env->startComponent('components.input-datetime', [
    'id' => 'data_final',
    'name' => 'data_final',
    'field' => 'data_final',
    'label' => 'Data Final',
    'inputSize' => 4,
    'dateTimeFormat' => 'DD/MM/YYYY',
    'picker_begin' => 'data_inicial',
    'picker_end' => 'data_final',
    'inputValue' => $data_final
]); ?>
<?php echo $__env->renderComponent(); ?>
<div class="col-sm-12 col-md-3 col-lg-3">                   
    <div class="form-group">
        <?php $__env->startComponent('components.label', ['label' => 'Tipo de Abastecimento', 'field' => $abast_local]); ?>
        <?php echo $__env->renderComponent(); ?>
        <div class="input-group">
            <div id="tipo_abastecimento" class="btn-group" data-toggle="buttons" >
                <label class="btn btn-default<?php echo e($abast_local == 1 ? ' active' : ''); ?>">
                    <input type="radio" name="abast_local" id="abast_local" value="1"> Local
                </label>
                <label class="btn btn-default<?php echo e($abast_local == 0 ? ' active' : ''); ?>">
                    <input type="radio" name="abast_local" id="abast_externo" value="0"> Externo
                </label>
                <label class="btn btn-default<?php echo e($abast_local == -1 ? ' active' : ''); ?>">
                    <input type="radio" name="abast_local" id="abast_todos" value="-1"> Todos
                </label>
            </div>
        </div>
    </div>
</div>

<script>
    $("#tipo_abastecimento :input").change(function() {
        $("#searchForm").submit();
    })
</script>