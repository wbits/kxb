var previousState;
var id;
var field;
var value;

$("td").click(function (event) {
    event.preventDefault();
    previousState = $(this);
    id = $(this).closest('tr').attr('id'),
    field = $(this).attr('class'),
    value = $(this).text();

    var newInput = $('<input type="text" />');

    console.log(newInput);
    newInput.val(value);
    $(this).innerHTML = newInput;
});
