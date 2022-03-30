<article class="ceps_cep">
        <h3><?="{$cep->cep} - {$cep->logradouro} - {$cep->bairro} - {$cep->localidade} - {$cep->uf}";?> </h3>
        <a class="remove" href="#" data-action="<?= $router->route("form.delete"); ?>"
        data-id="<?= $cep->id; ?>">Deletar</a>
</article>