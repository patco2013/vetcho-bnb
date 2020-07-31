$('#add-image').click(function()
{
    //I get the number of the future fields that I will create / Je récupère le numéro des futurs champs que je vais créer
    const index = +$('#widgets-counter').val();

    //I get the prototype of the entries / Je récupère le prototype des entrées.
    const tmpl = $('#ad_images').data('prototype').replace(/__name__/g, index);

    //I inject the code into my div / J'injecte le code au sein de ma div
    $('#ad_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    //Manage deleted Button / Gère le button supprimé
    handleDeleteButtons();
});

//Manage delete Button / Gère les buttons de suppression
function handleDeleteButtons()
{
    $('button[data-action="delete"]').click(function()
    {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter()
{
    const count = +$('#ad_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();
        