<script src="<?php echo e(asset('js/other.js')); ?>"></script>
<script>
    $('document').ready(function() {
        $('[data-toggle="tooltip"]').tooltip();

        $("#error-alert").fadeTo(8000, 600).slideUp(600, function(){
            $("#error-alert").slideUp(600);
        });
    });
</script>