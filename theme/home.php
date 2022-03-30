<?php $v->layout("_theme", ["title" => "Cep"]); ?>

<div class="create">
    <div class="form_ajax" style="display: none"></div>
    <form class="form" name="gallery" action="<?= $router->route("form.create");?>" method="post"
          enctype="multipart/form-data">
        <label>
            <input type="text" name="CEP" placeholder="Informe o CEP"/>
        </label>
        <button>Cadastrar CEP</button>
    </form>
</div>

<section class="ceps">
    <?php
    if (!empty($ceps)):
        foreach($ceps as $cep):  
            $v->insert("cep", ["cep" => $cep]);
        endforeach; 
    endif;
    ?>
</section>

<?php $v->start("js"); ?>
<script>
    $(function() {
        function load(action) {
            var load_div = $(".ajax_load"); 
            if (action === "open") {
                load_div.fadeIn().css("display", "flex");
            } else {
                load_div.fadeOut();
            }
        }
    
        $("form").submit(function (event) {
            event.preventDefault();
            var form = $(this);
            var form_ajax = $(".form_ajax");
            var ceps = $(".ceps");

            $.ajax({
                url: form.attr("action"),
                data: form.serialize(),
                type: "POST",
                dataType: "json",
                beforeSend: function () {
                    load("open");
                },
                success: function (callback) {
                    if (callback.message) {
                        form_ajax.html(callback.message).fadeIn();
                    } else {
                        form_ajax.fadeOut(function () {
                            $(this).html("");
                        });
                    }
                    if (callback.cep){
                        ceps.prepend(callback.cep);
                    }
                },
                complete: function () {
                    load("close");
                }
            })
        });

        $("body").on("click", "[data-action]", function(event) {
            event.preventDefault();
            var data = $(this).data();
            var div = $(this).parent();

            $.post(data.action, data, function() {
                div.fadeOut();
            },"json").fail(function() {
                alert("Erro ao processar requisição");
            });
        });

    });

</script>
<?php $v->end("js"); ?>